php-site-maker
=====

A simple static site generator powered by PHP, Markdown and mustache. Based on [github.com/lonescript/php-site-maker](http://github.com/lonescript/php-site-maker)


There are many other and better [staticsitegenerators](http://staticsitegenerators.net), but I searched for this features an did not found:

* edit without texteditor or ssh access. Using __webedit__ on your browser and get an textarea to change contents and create new pages.
* __meta information__ for rendering (template, menue etc) or html metatags are at the *bottom* o the page and optional
* no indexed, automatic __menu__; just an extra textblob. This is not so IT-sophisticated, but easy to understand.

Some more small features like titletags from the first heading, etc


## Write

Write files in [markdown extra](http://michelf.ca/projects/php-markdown/extra/).
All source code for cont is stored in ''_source/''

Edit your website in different ways:

* __normal__ edit source files on filesystem and with your favourite text-editor. After editing call `./make.sh` in you CLI
* __webedit__ with the edit button on the page. After 'save' the single page will be created.
* receive changes via __git__ (or other __DCVS__) and update the source and call make.php manually or with a hook.
* there is __no__ file and assethandling, just upload pictures and files in ths target directory. There is no reason why a static-site-generator should copy files around. And if you wish some filehandling like renaming, image resizing and cropping, use a specialized software.


## Administration

There is no extra admininterface, edit existing pages with the edit button or create new with calling the page you want. All information for the working admin on [admin.md](_source/admin.md).

Cconfiguration is editable on ech page and in [config](config).
Sidebar, manues and other page-durable content [pagedurable](_pagedurable) is stored like a ''normal'' page (the concept is well adapted in [Mediawiki Sidebar](https://www.mediawiki.org/wiki/Manual:Interface/Sidebar)).

## Style and JS

CSS and Javascript libraries are maintained in `lib/` as [submodule](http://git-scm.com/book/en/Git-Tools-Submodules)

* [CSS-Mini-Reset](https://github.com/vladocar/CSS-Mini-Reset/)
* [usefulclassroomphrases](https://github.com/klml/usefulclassroomphrases)
* [skeleton](https://github.com/dhg/Skeleton)

Addtional you can have css and js in your template directory and local custom files.

### Custom

You can edit custom client-sources (css, js) in [_custom-css](_custom-css) and [_custom-js](_custom-js) as "normal" pages
(the concept is well adapted in [Mediawiki UseSiteCss](https://www.mediawiki.org/wiki/Manual:$wgUseSiteCss) and [SiteJs](https://www.mediawiki.org/wiki/Manual:%24wgUseSiteJs)).


## Setup

Clone or download, create config from .example and create first version of site.

```
git clone https://github.com/klml/php-site-maker.git
cd php-site-maker/_make/
cp config.yml.example config.yml
php make.php
```

Used libraries are included as [submodules](http://git-scm.com/book/en/Git-Tools-Submodules).

```
git submodule init
git submodule update 
```


The public site, where ever it is located (other server, CDN, etc), needs only html and js files. Only `_make/`-directory is needed for changing content. The `make.php` has **no role or user validation**, Protect this against violaton:

* .htaccess for the whole *_make/*-directory. (Change existing .htaccess to a suitable [Basic access authentication](http://en.wikipedia.org/wiki/Basic_access_authentication))
* use editing only on secure machines like your desktop or intranet and publish all without *_make/* (e.g. `rsync --exclude=_make/`)

Run `./make.sh` or [_make/make.php](_make/make.php) for the first run.


## make

All processing in '_make/make.php' to create static html files from *_source/* 'compiled' with all *_template/*

Now the __webserver__ can deliver pure html files. If you want an URL without the extension .html [rewrite](http://stackoverflow.com/questions/10245032/url-rewrite-remove-html/10279744#10279744) in [.htaccess](.htaccess).

### config.yml

Metainformation (template, comments, meta-description, title etc) can be defined in [yaml](http://www.yaml.org/spec/1.2/spec.html)

* for __each page__ at the bottom of sourcefile after the `#meta#` (can be redefined in config 'ymlseparator').
* or for each __directory__ in `config.yml` or for the whole site in `_source`.
* and as fallback and for pathes in `_make/config.yml`.

#### site wide

site-wide configurations, only usable in `_make/config.yml`.

siteName
: used after  

baseurl
: root url *http://example.com* or *http://example.com/mypage* for absolute URL inside the html. Works also with relative (leave empty).

disqusId
: if using [disqus.com](http://disqus.com/) for comments

htmlextension
: filename extension for html output. Mostly '.html'.

sourceextension
: filename extension for text sourcefiles

ymlseparator
: tag in pages to seperate content and config (`#meta#`).

path
: filepath for templates, text-source and target for html.

#### page specific

Are used for every single page, but can get overwritten in directory or _make/config.yml.

layout
: template

title and description
: [HTML Title Element](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/title) and meta description

comment
: allow comments

pagedurable
: parts of the page always appear like the menu.


## templates

Using [mustache](https://github.com/bobthecow/mustache.php), it is [logic-less in a religious way](http://upstatement.com/blog/2013/10/comparing-php-template-languages-for-wordpresss/), but you can use [mustache](http://mustache.github.io/) in JavaScript on your client.(TODO;)


For [webedit](#Write) add the [HTML metatag](http://www.w3.org/wiki/HTML/Elements/meta) [dcterms.source](http://dublincore.org/documents/dcmi-terms/#terms-source) (Referenced[whatwg.org MetaExtensions](http://wiki.whatwg.org/wiki/MetaExtensions#Registered_Extensions) ).

```
<link rel="schema.dcterms" href="http://purl.org/dc/terms/">
<meta name="dcterms.source" content=""/>
```

In  `lib/` are some clientside libraries (css, js).

Existing templates


## TODO

- rename $this->config siteconfig
- rename $tmpInfo pageconfig or pagemeta  and add tpl array 
- rename $this->filePath['layout']
- http://php.net/manual/de/function.realpath.php
- source config without passwords etc
- 404 to root
- _make/config.yml to js serversite https://github.com/coolaj86/yamltojson.com
- source versioning
- rename project gidig
    - _custom-css etc psm-custom-css
- redirects
- new article field (and include)
- [ ] prevent webedit by meta and class
- [ ] jquery als lib
- [ ] onsite preview https://github.com/tanakahisateru/js-markdown-extra
- [ ] skip meta
- [ ] include http://www.mediawiki.org/wiki/Transclusion
- [ ]* index: dir as link include (for pix)
- [ ] demo
- [ ] data2css aus meta fill
- [ ] trailing slash
- [ ] lib: https://github.com/michelf/php-markdown extra (needs php 5.3)
- [ ] lib: https://github.com/lepture/editor
- [ ] minfy
- [ ] CSS-Mini-Reset realy needed
- [ ] after pagedurable creat with all pages
- [ ] js var psmpage
- [ ] https://github.com/blueimp/jQuery-File-Upload
- [ ] URL builing? root dir : absolute relative only one dir
- [ ]* directory to namespace
- [ ]* directory doubled
- [ ]* global filenamepath
- [ ] test if yml exists from func
- [ ] bloggish posttemplate (date, archivcat) for webedit
- [ ] tags
- [ ] lasttest
- [ ] etherpad
- [ ] doku images timestamp


### Refactor

- [ ] 404 er save
- [ ] lib https://github.com/michelf/php-markdown extra (needs php 5.3)
