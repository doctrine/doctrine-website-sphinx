# Doctrine-Project.org Website

We built our complete website with [Tinkerer](http://tinkerer.me), which includes some sophisticated
plugins that generate project details and hooks into Github.

The contents of the page are located in `site/` directory.

## Installation

1. Clone this repository.
2. From the root repository directory install all dependencies:

        $ pip install -r requirements.txt

## Contributing

To write a new blog post just `cd site/` and then call the following to create a draft:

    $ tinker -d "Title of Post"

Open a pull request with the draft and we will publish it once accepted.

You can build and view the page by callling `tinker -b` in the `site/` directory.
