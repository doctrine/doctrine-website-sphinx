:author: Benjamin Eberlei <kontakt@beberlei.de>
:date: 2013-03-24 00:00:00

===========================
Doctrine 2.4 Beta1 released
===========================

**24.03.2013**

We have released the first beta version of Doctrine 2.4. Some of
the changes are listed in `this talk
<https://speakerdeck.com/asm89/what-is-new-in-doctrine>`_ by Alexander
and me from Symfony Live Berlin last year.

You can install the release through `Github <https://github.com/doctrine/doctrine2>`_,
download, PEAR or `Composer <http://www.packagist.org>`_:

.. code-block:: 

    {
        "require": {
            "doctrine/orm": "2.4.0-beta1",
            "doctrine/dbal": "2.4.0-beta1",
            "doctrine/common": "2.4.0-rc1"
        }
    }

Please test this release with your existing applications to allow
us to find BC breaks and remove them before the final release. The plan
is to release the final version in the next 4-6 weeks.

In these next weeks we will work to incorporate all changes in the
documentation.
