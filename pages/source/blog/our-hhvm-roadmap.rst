:date: 2013-12-23 10:00:00
:author: Benjamin Eberlei <kontakt@beberlei.de>

================
Our HHVM Roadmap
================

Facebook has been pushing HHVM much lately, helping big open source projects to
get their test-suite running 100%. HHVM is particularly interesting for
Doctrine, because of the performance gains that the very complex PHP algorithms
in ORM would probably get. With the tests not yet passing on the ORM, we cannot
measure how big that performance improvement will be.

Now with Travis CI support for HHVM now available we think it is time to
announce our HHVM Roadmap as Doctrine project.

One of our goals for 2014 is running DBAL and ORM on HHVM with 100% of the
testsuites passing. Every Doctrine subproject targeting to support HHVM will
start running the tests against HHVM with ``allow_failure`` enabled on Travis
CI.

Whenever a Doctrine subproject passes all its tests on HHVM, we will remove the
``allow_failure`` and the project will be officially supporting HHVM from that
version on.

So far we have been working on the Common projects to run on HHVM for several
months now and Guilherme and Alexander are contributing to HHVM itself to get
some missing APIs working. We are happy to announce that the following Common
projects currently have full HHVM support from us:

- Collections
- Inflector
- Lexer

Guilherme is working on getting Annotations finished and the Common mainproject
will be evaluated after that. DBAL and ORM will be much more work, but we are
very confident to achieve this goal.
