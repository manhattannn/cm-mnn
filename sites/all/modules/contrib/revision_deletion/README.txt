CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Requirements
 * Installation
 * Configuration
 * Maintainers


INTRODUCTION
------------

This modules enables the ability to mass delete aging node revisions. The
revisions may be deleted after review on an administer page as well. This module
will NEVER delete the current revision of a node, nor will it allow you to do
so.

 * For a full description of the module, visit the project page:
   https://www.drupal.org/project/revision_deletion

 * To submit bug reports and feature suggestions, or to track changes:
   https://www.drupal.org/project/issues/search/revision_deletion


REQUIREMENTS
------------

No special requirements.


INSTALLATION
------------

 * Install as you would normally install a contributed Drupal module.
   See: https://www.drupal.org/node/895232 for further information.


CONFIGURATION
-------------

 * Configure the module in Administration » Configuration »
   Content authoring » Revision Deletion » Settings:

   - Possible settings include node type, the age of node revision before being
     deleted, along with a cron frequency setting. For this you need the
     'Administer Revision Deletion' permission.

 * Deletions can be manually run at Administration » Configuration »
   Content authoring » Revision Deletion. A review screen will display all the
   node revisions that meet the settings criteria.


MAINTAINERS
-----------

Current maintainers:
 * Adrian Cid Almaguer (adriancid) - https://www.drupal.org/u/adriancid
