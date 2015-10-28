Cache 1.4.3 and 1.5.0 Released
==============================

We are happy to announce the immediate availability of Doctrine Cache
`1.4.3 <https://github.com/doctrine/cache/releases/tag/v1.4.3>`_ and
`1.5.0 <https://github.com/doctrine/cache/releases/tag/v1.5.0>`_.

Cache 1.4.3
~~~~~~~~~~~

This release fixes some minor issues that prevented various cache adapters
from correctly reporting success or failure in case of cache key deletion
(`#95 <https://github.com/doctrine/cache/pull/95>`_).

Another issue being fixed is related to ``CacheProvider#fetchMultiple()``,
which was failing to operate when an empty list was given to it
(`#90 <https://github.com/doctrine/cache/pull/90>`_).

Also, the ``CacheProvider`` does not store version information internally
unless ``CacheProvider#deleteAll()`` was called at least once
(`#91 <https://github.com/doctrine/cache/pull/91>`_).

You can find the complete changelog for this release in the
`v1.4.3 release notes <https://github.com/doctrine/cache/releases/tag/v1.4.3>`_.


You can install the Cache component using Composer either of the following
``composer.json`` definitions:

.. code-block:: json

  {
      "require": {
          "doctrine/cache": "1.4.1"
      }
  }

.. code-block:: json

  {
      "require": {
          "doctrine/cache": "1.5.0"
      }
  }

Please report any issues you may have with the update on the mailing list or on
`Jira <http://www.doctrine-project.org/jira>`_.

.. author:: Marco Pivetta <ocramius@gmail.com>
.. categories:: Release
.. tags:: none
.. comments::
