Doctrine MongoDB ODM release 1.0.3
==================================

We are happy to announce the immediate availability of Doctrine MongoDB ODM
`1.0.3 <https://github.com/doctrine/cache/releases/tag/v1.0.3>`__.

Reusing embedded documents
--------------------------

Until now we advised developers to deep clone each and every embedded document that needs to change owner or
`strange <https://github.com/doctrine/mongodb-odm/issues/1229`__
`things <https://github.com/doctrine/mongodb-odm/issues/1169>`__
`could <https://github.com/doctrine/mongodb-odm/issues/478>`__
`happen <https://www.youtube.com/watch?v=dQw4w9WgXcQ>`__. It was perfectly fine from our point of view since
ODM needs to track changes, store parent associations and manage lifecycle for each and every document, be it normal or
embedded, and it was logical that these documents can not be same instances for Doctrine to work properly.

*It is no loner needed!*

From now on ODM will do all the heavy lifting for you and each and every document that was found reused during ``persist``
or ``flush`` shall be cloned by ``UnitOfWork`` and set back to your original document or collection.

Other bug fixes
---------------

Most important fixes may be found in the
`changelog <https://github.com/doctrine/mongodb-odm/blob/master/CHANGELOG-1.0.md#103-2015-11-03>`__
while for full list of issues and pull requests in this release please refer to
`1.0.3 milestone <https://github.com/doctrine/mongodb-odm/issues?q=milestone%3A1.0.3>`__.

Work on 1.1 is starting and it will require PHP 5.5+
----------------------------------------------------

We are happy to announce that work on 1.1 is commencing! While no dates have been set yet you can take a look on
`1.1 milestone <https://github.com/doctrine/mongodb-odm/issues?q=milestone%3A1.1>`__ for brief list of goodies we intend
to ship next. If you want to suggest another feature or want to help please do get in touch, from our side we are working
hard to include `hydrating aggregation results <https://github.com/doctrine/mongodb-odm/pull/1263>`__, especially that
`$lookup operator <https://www.mongodb.com/blog/post/revisiting-usdlookup>`__ is around the corner, and
`custom collection classes <https://github.com/doctrine/mongodb-odm/pull/1219>`__ for ``EmbedMany`` and ``ReferenceMany``.

Current ``master`` branch will soon become development branch for 1.1 and *has PHP requirement bumped to 5.5*. If you
can not upgrade your PHP please use ``~1.0.3`` version constraint in your ``composer.json`` (or you can use
`1.0.x branch <https://github.com/doctrine/mongodb-odm/tree/1.0.x>`__ by specifying ``dev-1.0.x`` to obtain latest bug
fixes before we tag them).

.. author:: Maciej Malarz <malarzm@gmail.com>
.. categories:: none
.. tags:: none
.. comments::
