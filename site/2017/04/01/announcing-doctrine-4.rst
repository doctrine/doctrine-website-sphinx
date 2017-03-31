Announcing Doctrine 4
=====================

It has been few months since we shed some light on `future of Doctrine project <https://github.com/doctrine/doctrine2/issues/6211>`__
and had an extensive insight into what `Guilherme <https://twitter.com/guilhermeblanco>`__ had been up to. Adding
tens of megabytes of IRC logs of internal discussion we felt we owe you an update on where Doctrine is and where
it's heading to:

Doctrine 3 is no more!
----------------------

Be asured, in no way we are ditching all the code Guilherme hacked so far or any of the ideas that sprung
for the next major release. We are still looking into leveraging all goodies that were given to us with PHP 7.
We still want next Doctrine to be extremely stable and realiable piece of software you are all used to. But also
we are still trying to figure out how to maintain all projects under Doctrine's umbrella effectively. To recap,
Doctrine is not only the ORM you all know, we are also maintaining a number of ODM projects (`MongoDB <https://github.com/doctrine/mongodb-odm>`__
or `CouchDB <https://github.com/doctrine/couchdb-odm>`__ to name few) which all share basic concepts and code.
Some of them are also to face major rewrite, just like much anticipated MongoDB ODM 2.0 with support for new MongoDB driver.

Joining Forces
--------------

Instead of having each team iterate on its own, implementing same concepts multiple times across various libraries,
we decided it is for the best that we all work on one project and make it as good and robust as possible.
We decided it's time to break boundaries so Doctrine 4 will be all about interoperability. **Doctrine 4 will support
both RDBMS and NoSQL databases at the same time!**

Following latest trends
-----------------------

A really big thing we want to (re)introduce is an Active Record pattern. We've ran a poll on the #doctrine IRC
channel and it turned out that 68% of developers are dying a little bit each time they are injecting a service which
barely saves data to a database and miss simplicity of having an entity save itself.

.. code-block:: php

    use Doctrine;

    /**
     * @Doctrine\Entity(storage="MSSql")
     * @Doctrine\ActiveRecord
     */
    class User
    {
        /** @Doctrine\Id */
        public $id;

        /** @Doctrine\Field(type="string") */
        public $login;
    }

    $user = new User();
    $user->load(10);
    $user->login = 'malarzm';
    $user->save();

Thanks to ``@Doctrine\ActiveRecord`` annotation you're able to query for and save your entities easily. Please
notice, that `User` class does not extend any internal Doctrine class - you are still decoupled from us!

We strongly believe that getting back to Active Record pattern is the way to go for us. We weren't able to
fully get rid of old fashioned Data Mapper but you can expect it's deprecation in one of first bug-fix releases
and full removal shortly after.

Another big step towards much expected nowadays Developer eXperience was initially painful, as it required many
of us to come out of a Java bubble we live in, but we hope it will be for the best. With re-introduction of
Active Record natural next step is making all Doctrine utilities available in an easy and sane way: please welcome
fascades AND short method names!

.. code-block:: php

    use Doctrine;
    use Entity\MongoLog;
    use Entity\User;

    Doctrine::em()->start(); // start a transaction
    $user = new User(); // this is stored in MSSql
    $user = 'malarzm';
    $user->save(); // not saved yet
    $log = new MongoLog($user, 'was created'); // this will be stored in Mongo
    $log->save(); // but not yet
    Doctrine::em()->commit(); // commit a transaction ACROSS storages

Big shout out goes to `Marco <https://twitter.com/Ocramius>`__, who initially had an heart attack when he
heard the idea, but now after using the feature is a big proponent of Fascades. Be sure to watch for updates
in all his libraries in near future!

Try it out now!
---------------

Uniting forces of all Doctrine developers has enabled us to ship an usable "alpha" version way sooner than originally
estimated. But the truly thrilling news is that thanks to tremendous help from guys with `3v4l.org <https://3v4l.org/>`__
we have set up a sandbox environment so everybody can have a hands-on experience using new version of Doctrine:
please visit `3v4l.org/doctrine4 <https://ocrami.us/>`__ and share your thoughts in the comments section below!

.. author:: Maciej Malarz <malarzm@gmail.com>
.. categories:: none
.. tags:: none
.. comments::
