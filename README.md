# Doctrine-Project.org Website

We built our complete website with [Tinkerer](http://tinkerer.me), which includes some sophisticated
plugins that generate project details and hooks into Github.

The contents of the page are located in `site/` directory.

To write a new blog post just `cd site/` and then call the following to create a draft:

    $ tinker -d "Title of Post"

Open a pull request with the draft and we will publish it once accepted.

You can build and view the page by callling `tinker -b` in the `site/` directory.
Make sure to `sudo pip install tinkerer` to get the required dependencies.
