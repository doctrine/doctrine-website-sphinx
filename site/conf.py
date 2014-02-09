# -*- coding: utf-8 -*-

import sys, os
import tinkerer
import tinkerer.paths

# **************************************************************
# TODO: Edit the lines below
# **************************************************************

# Change this to the name of your blog
project = 'Doctrine Project'

# Change this to the tagline of your blog
tagline = 'Persistence Libraries for PHP'

# Change this to the description of your blog
description = 'The Doctrine Project is the home of a selected set of PHP libraries primarily focused on providing persistence services and related functionality.'

# Change this to your name
author = 'Doctrine Team'

# Change this to your copyright string
copyright = '2006-2014, ' + author

# Change this to your blog root URL (required for RSS feed)
website = 'http://www.doctrine-project.org/'

# **************************************************************
# More tweaks you can do
# **************************************************************

# Add your Disqus shortname to enable comments powered by Disqus
disqus_shortname = 'doctrineproject'

# Change your favicon (new favicon goes in _static directory)
html_favicon = 'doctrine.ico'

# Pick another Tinkerer theme or use your own
html_theme = "doctrine"

# Theme-specific options, see docs
html_theme_options = { }

# Link to RSS service like FeedBurner if any, otherwise feed is
# linked directly
rss_service = None

# Generate full posts for RSS feed even when using "read more"
rss_generate_full_posts = True

# Number of blog posts per page
posts_per_page = 5

# Character use to replace non-alphanumeric characters in slug
slug_word_separator = '_'

# **************************************************************
# Edit lines below to further customize Sphinx build
# **************************************************************

sys.path.append(os.path.abspath('_exts'))

# Add other Sphinx extensions here
extensions = ['tinkerer.ext.blog', 'tinkerer.ext.disqus', 'doctrineprojects', 'doctrinedownloads']

# Add other template paths here
templates_path = ['_templates']

# Add other static paths here
html_static_path = ['_static', tinkerer.paths.static]

# Add other theme paths here
html_theme_path = ['_themes', tinkerer.paths.themes]

# Add file patterns to exclude from build
exclude_patterns = ["drafts/*", "_templates/*"]

# Add templates to be rendered in sidebar here
html_sidebars = {
    "**": ["recent.html", "searchbox.html"]
}

# **************************************************************
# Do not modify below lines as the values are required by
# Tinkerer to play nice with Sphinx
# **************************************************************

source_suffix = tinkerer.source_suffix
master_doc = tinkerer.master_doc
version = tinkerer.__version__
release = tinkerer.__version__
html_title = project
html_use_index = False
html_show_sourcelink = False
html_add_permalinks = None
