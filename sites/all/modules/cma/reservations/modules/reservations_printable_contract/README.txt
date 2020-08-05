 +---------------------------------------------------------------------------+
 | Copyright (C) 2009 Openflows, Inc. + Blue Bag. All rights reserved.       |
 | Additionally, Kevin Reynen                                |
 |                                                                           |
 | This work is published under the GNU AGPLv3 license without any           |
 | warranty. For full license and copyright information, see                 |
 | https://www.gnu.org/licenses/agpl-3.0.html                                |
 +---------------------------------------------------------------------------+

Reservations Printable Contract

Development of this module is on Community Media Advanced on github here:
https://github.com/cm-advanced/cma_reservations_printable_contract

Formore info go here:
https://cmadvanced.wordpress.com/


Adds a printable contract option to Reservation nodes.

INSTALLATION
-------------------------
If you will be the replacing the Cost columns, you will need to add a
user-defined field to the reservable content types. The field name and header
for the column on the contract can be defined on the configuration page
(admin/config/reservations/contract) or the default values can be used.

      Label: User-Defined
      Machine Name: user-defined field [field_reservable_contract_text (default)]
      Field Type: Long text
      Widget: Text area (multiple rows)

Checking Replace Cost Columns with Accessories Column on the settings page will
allow the user-defined field to appear on the contract.

How to Apply GNU AFFERO GENERAL PUBLIC LICENSE Terms to Your New Programs - see LICENSE.txt

If you develop a new program, and you want it to be of the greatest possible use to the public, the best way to achieve this is to make it free software which everyone can redistribute and change under these terms.

To do so, attach the following notices to the program. It is safest to attach them to the start of each source file to most effectively state the exclusion of warranty; and each file should have at least the "copyright" line and a pointer to where the full notice is found.

    <one line to give the program's name and a brief idea of what it does.>
    Copyright (C) <year>  <name of author>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.

Also add information on how to contact you by electronic and paper mail.

If your software can interact with users remotely through a computer network, you should also make sure that it provides a way for users to get its source. For example, if your program is a web application, its interface could display a "Source" link that leads users to an archive of the code. There are many ways you could offer source, and different solutions will be better for different programs; see section 13 for the specific requirements.