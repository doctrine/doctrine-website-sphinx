Doctrine MongoDB ODM release 1.0.0
==================================

In observance of August 18th, the day Jon Wage tagged `first BETA <https://github.com/doctrine/mongodb-odm/releases/tag/1.0.0BETA1>`__
release of ODM, we gathered here to celebrate big. What began as a weekend hack to port Doctrine 2's data mapper pattern
to NoSQL, has quickly become a beast cutting its teeth on production servers early on as a core dependency of the very
first Symfony2 startups. Today, after five years of adoption, improvements, refactoring and
`countless jokes <https://twitter.com/jmikola/status/583047759160336384?lang=en>`__ we are happy to announce the
immediate availability of Doctrine MongoDB ODM 1.0.0!

What is new in 1.0.0?
---------------------

For the stable release we focused on fixing known bugs (yes, we fixed even these opened for years), hardening existing
features and straightening ODM's behaviour in certain cases. To ensure pleasant update we have prepared a
`checklist <https://github.com/doctrine/mongodb-odm/blob/master/CHANGELOG-1.0.md#100-2015-08-18>`__ for
you with most important changes that may require your attention. Full list of closed issues and pull requests can be
found on the GitHub under `1.0.0 milestone <https://github.com/doctrine/mongodb-odm/issues?q=milestone%3A1.0.0>`__.

doctrine/mongodb 1.2.0 behind the scenes
----------------------------------------

We are also happy to announce the immediate availability of 1.2.0 version of underlying doctrine/mongodb abstraction
layer. With this release you are given brand new `Aggregation Builder <https://github.com/doctrine/mongodb/pull/213>`__,
Query builder support for `update<https://github.com/doctrine/mongodb/pull/212>`__ and
`$text<https://github.com/doctrine/mongodb/pull/184>`__ operators introduced by MongoDB 2.6. For the full list of closed
issues and pull requests please see `release notes on GitHub<https://github.com/doctrine/mongodb/releases/tag/1.2.0>`__.

Stop fooling around, I want my BETA back!
-----------------------------------------

We are really sorry for inconvenience, Doctrine MongoDB ODM has gone stable and we are not shipping more BETAs. Well not
until we start working on 2.0 version so please be patient.

.. author:: Maciej Malarz <malarzm@gmail.com>
.. categories:: none
.. tags:: none
.. comments::
