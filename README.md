# Doctrine-Project.org Website

We built our complete website with Sphinx, which includes some sophisticated plugins that generate
project details and hooks into Github.

## Process

### bin/build-project.php

Transforms the ``project.yml`` into ``pages/source/project.yml`` and enhances it with Github
release data that is necessary for the Sphinx extensions.
