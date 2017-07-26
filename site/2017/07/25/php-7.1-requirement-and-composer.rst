PHP 7.1 requirement for Doctrine packages
=========================================

A few days ago, the Doctrine team released new versions of many packages, dropping
support for PHP 5.6 and 7.0, as well as HHVM. The affected packages are:

- doctrine/common 2.8.0
- doctrine/dbal 2.6.0
- doctrine/collections 1.5.0
- doctrine/inflector 1.2.0
- doctrine/cache 1.7.0
- doctrine/instantiator 1.1.0
- doctrine/annotations 1.5.0

Since many people are encountering issues with these updates, here are a few
suggestions to ensure your code continues working as usual.

Composer version constraints
----------------------------

Chances are your version constraints in ``composer.json`` look something like this:

.. code-block:: json

    {
        "require": {
            "doctrine/orm": "^2.5"
        }
    }

The ``^2.5`` constraint resolves to: ``>= 2.5.0 && <= 2.999999.999999``. This is
intended: our projects all follow `Semantic Versioning <http://semver.org/>`__,
so you can safely install a new minor version without having to fear BC breaks.

When determining what version to install, composer employs a SAT solver to make
sure all dependencies are fulfilled. In our example above, the SAT solver finds
a version newer than 2.5 that satisfies all requirements.

Making sure you get a compatible version
----------------------------------------

When you run ``composer update`` the next time, you'll automatically receive
updates for the packages mentioned above, provided that you are running on PHP
7.1. If you are running an older PHP version, composer will not install a version
that requires PHP 7.1, since its requirements are not fulfilled.

A common problem is people running a newer PHP version on their developer machines
than on their production servers. In this case, running ``composer update`` on
a developer machine (with PHP 7.1) might happily pull in an update that simply
won't work when deployed on a production machine running PHP 5.6.

To make sure this doesn't happen to you, there are two choices:

-  run ``composer update`` on a machine with the same PHP version that you use
   in production
-  use the `platform.config <https://getcomposer.org/doc/06-config.md#platform>`__
   config setting in ``composer.json`` to override your local PHP version.

Why dropping PHP support in a minor version is not a BC break
-------------------------------------------------------------

One question we frequently hear is, "isn't dropping support for a PHP version a
BC break"? In a nutshell, no. A BC break happens when there is an incompatible
change that your package manager can't handle. For example, changing a method
signature in a minor version is a no-go, since the composer version constraints
mentioned above assume any minor upgrade can safely be used.

However, when we drop support for an older version of PHP, composer will not
consider the new version if the PHP version requirement is no longer fulfilled.
Thus, you won't end up with a fatal error due to a wrong method signature, you
just won't get the new version.

.. author:: Andreas Braun <alcaeus@alcaeus.org>
.. categories:: none
.. tags:: none
.. comments::
