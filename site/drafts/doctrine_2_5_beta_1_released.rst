Doctrine 2.5 Beta 1 released
============================

We are happy to announce the Beta1 release of the forthcoming Doctrine 2.5
release. Due to day-job related responsibilities, we are a month behind our
schedule. Please bear with us as we prepare this new release.

The following changes happend since `Alpha2
<https://github.com/doctrine/doctrine2/releases/tag/v2.5.0-alpha2>`_:

- [`DDC-3452 <http://www.doctrine-project.org/jira/browse/DDC-3452>`_] Embeddables Support for ClassMetadataBuilder 
- [`DDC-3551 <http://www.doctrine-project.org/jira/browse/DDC-3551>`_] Load platform lazily in ClassMetadataFactory to avoid database connections.
- [`DDC-3258 <http://www.doctrine-project.org/jira/browse/DDC-3258>`_] Improve suport for composite primary keys and assocations as keys.
- [`DDC-3554 <http://www.doctrine-project.org/jira/browse/DDC-3554>`_] Allow to recreate DQL QueryBuilder from parts.
- [`DDC-3461 <http://www.doctrine-project.org/jira/browse/DDC-3461>`_] Allow setting association as primary key in ClassMetadataBuilder API with ``makePrimaryKey()``.
- [`DDC-3587 <http://www.doctrine-project.org/jira/browse/DDC-3587>`_] Added programmatical support to define indexBy on root aliases.
- [`DDC-3588 <http://www.doctrine-project.org/jira/browse/DDC-3588>`_] Add support for seconds in ``DATE_ADD`` DQL function.
- [`DDC-3585 <http://www.doctrine-project.org/jira/browse/DDC-3585>`_] Fix instantiation of nested embeddables.
- [`DDC-3607 <http://www.doctrine-project.org/jira/browse/DDC-3607>`_] Add support for orphan removal in ClassMetadataBuilder/AssocationBuilder
- [`DDC-3597 <http://www.doctrine-project.org/jira/browse/DDC-3597>`_] Add support for embeddables in MappedSuperclasses.
- [`DDC-3616 <http://www.doctrine-project.org/jira/browse/DDC-3616>`_] Add support for DateTimeImmutable in Query parameter detection.
- [`DDC-3622 <http://www.doctrine-project.org/jira/browse/DDC-3622>`_] Improve support for objects as primary key by casting to string in UnitOfWork.
- [`DDC-3619 <http://www.doctrine-project.org/jira/browse/DDC-3619>`_] Update IdentityMap when entity gets managed again fixing ``spl_object_hash`` collision.
- [`DDC-3608 <http://www.doctrine-project.org/jira/browse/DDC-3608>`_] Fix bug in EntityGenerator to XML/YML with default values.
- [`DDC-3590 <http://www.doctrine-project.org/jira/browse/DDC-3590>`_] Fix bug in PostgreSQL with naming strategy of non-default schema tables.
- [`DDC-3566 <http://www.doctrine-project.org/jira/browse/DDC-3566>`_] Fix bug in Second-Level Cache with association identifiers.
- [`DDC-3528 <http://www.doctrine-project.org/jira/browse/DDC-3528>`_] Have ``PersistentCollection`` implement ``AbstractLazyCollection`` from `doctrine/collections <https://github.com/doctrine/collections>`_`.
- [`DDC-3567 <http://www.doctrine-project.org/jira/browse/DDC-3567>`_] Allow access to all aliases for a QueryBuilder.


.. author:: default
.. categories:: none
.. tags:: none
.. comments::
