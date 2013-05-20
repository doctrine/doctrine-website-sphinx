# Doctrine-Project.org Website

We built our complete website with Sphinx, which includes some sophisticated plugins that generate
project details and hooks into Github.

## Installation

To use this project, you will need [ANT](http://ant.apache.org/). You can install it by running:

```sh
sudo apt-get install ant
```

You can install additionally required dependencies by running

```sh
sudo ant install-sphinx
```

You will also need to generate an API token for github in order to fetch tag/release information
from the github repositories:

```sh
./bin/generate-github-token.sh
```

## Build

To build the website, simply run `ant` in the root of your cloned repository.
