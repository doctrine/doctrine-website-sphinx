Doctrine Annotations 1.2.4 Release
==================================

We are happy to announce the immediate availability of Doctrine Collections ``1.2.4``.

This release fixes a minor issue (`#51 <https://github.com/doctrine/annotations/pull/51>`_) with
highly concurrent I/O and the ``FileCacheReader#saveCacheFile()`` method.

Installation
------------

You can install this version of Doctrine Annotations by using Composer and the
following ``composer.json`` contents:

.. code-block:: json

  {
      "require": {
          "doctrine/annotations": "1.2.4"
      }
  }

Please report any issues you may have with the update on the mailing list or on
`Jira <http://www.doctrine-project.org/jira/browse/DCOM>`_.

.. author:: Marco Pivetta <ocramius@gmail.com>
.. categories:: none
.. tags:: none
.. comments::
