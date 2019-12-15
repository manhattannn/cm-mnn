<<<<<<< HEAD
Field collection
-----------------
Provides a field collection field, to which any number of fields can be attached.
=======
CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Requirements
 * Installation
 * Configuration
 * Using field collection with entity translation
 * Maintainers


INTRODUCTION
------------

Provides a field collection field to which any number of fields can be attached.
>>>>>>> origin/stage

Each field collection item is internally represented as an entity, which is
referenced via the field collection field in the host entity. While
conceptually field collections are treated as part of the host entity, each
field collection item may also be viewed and edited separately.


<<<<<<< HEAD
 Usage
 ------

  * Add a field collection field to any entity, e.g. to a node. For that use the
   the usual "Manage fields" interface provided by the "field ui" module of
   Drupal, e.g. "Admin -> Structure-> Content types -> Article -> Manage fields".

  * Then go to "Admin -> Structure-> Field collection" to define some fields for
   the created field collection.

  * By the default, the field collection is not shown during editing of the host
    entity. However, some links for adding, editing or deleting field collection
    items is shown when the host entity is viewed.

  * Widgets for embedding the form for creating field collections in the
    host-entity can be provided by any module. In future the field collection
    module might provide such widgets itself too.


 Using field collection with entity translation
 -----------------------------------------------

  * Field collection items must be selected as a translatable entity type at
=======
REQUIREMENTS
------------

This project require the following projects:

 * Entity API (https://www.drupal.org/project/entity)


INSTALLATION
------------

Install as you would normally install a contributed Drupal. See:
https://drupal.org/documentation/install/modules-themes/modules-7 for further
information.


CONFIGURATION
-------------

 * Add a field collection field to any entity, e.g. to a node. For that use the
   the usual "Manage fields" interface provided by the "field ui" project of
   Drupal, e.g "Admin -> Structure -> Content types -> Article -> Manage fields"

 * Then go to "Admin -> Structure-> Field Collection" to define some fields for
   the created field collection.

 * By the default, the field collection is not shown during editing of the host
    entity. However, some links for adding, editing or deleting field collection
    items is shown when the host entity is viewed.

 * Widgets for embedding the form for creating field collections in the
    host-entity can be provided by any module. In future the field collection
    project might provide such widgets itself too.


USING FIELD COLLECTION WITH ENTITY TRANSLATION
-----------

  * Field Collection items must be selected as a translatable entity type at
>>>>>>> origin/stage
    Admin -> Config -> Regional -> Entity Translation.

  * The common use case is to leave the field collection field untranslatable
    and set the necessary fields inside it to translatable.  There is currently
    a known issue where a host can not be translated unless it has at least
    one other field that is translatable, even if some fields inside one of
    its field collections are translatable.

  * The alternate use case is to make the field collection field in the host
    translatable.  If this is done it does not matter whether the inner fields
    are set to translatable or not, they will all be translatable as every
    language for the host will have a completely separate copy of the field
    collection item(s).

<<<<<<< HEAD
  * When using nested field collections the configuration of the fields and
    field collections is very important. The recommended approach is to first
    enable entity translation as defined in step 1, and set the outer 
    field collection field as translatable, and all it’s sub-fields to language
    undefined. Also the sub-field collections and it’s sub-fields should be
    set to language undefined. This will ensure that every language of the host
    will have a completely separate copy of the field collection item(s) and
    it’s fields.
=======
  * When using nested field collections, the configuration of the fields and
    field collections is very important. The recommended approach is to first
    enable entity translation as defined in step 1, and set the outer
    field collection field as translatable and all its sub-fields to language
    undefined. The sub-field collections and its sub-fields should also be
    set to language undefined. This will ensure that every language of the host
    will have a completely separate copy of the field collection item(s) and
    its fields.


MAINTAINERS
-----------

Current maintainers:
 * Joel Muzzerall (jmuzz) - https://www.drupal.org/user/2607886
 * Joel Farris (Senpai) - https://www.drupal.org/user/65470
 * Lee Rowlands (larowlan) - https://www.drupal.org/user/395439
 * Nedjo Rogers (nedjo) - https://www.drupal.org/user/4481
 * Ra Mänd (ram4nd) - https://www.drupal.org/user/601534
 * Renato Gonçalves (RenatoG) - https://www.drupal.org/user/3326031
 * Wolfgang Ziegler (fago) - https://www.drupal.org/user/16747
>>>>>>> origin/stage
