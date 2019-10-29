CONTENTS OF THIS FILE
=====================
  * Introduction
  * Requirements
  * Installation
  * Configuration


INTRODUCTION
============
  * The Http Client Manager module provides the ability to use the Guzzle Http Client.
  It also exposes hooks to define server and cert settings. It also provides
  an Admin UI for configuring the implemented server settings. It will also 
  provide environment settings (dev, staging, prod).


REQUIREMENTS
============
There are no module dependencies.

INSTALLATION
============
  * Installation for this module should be as simple as installing the module in
   the UI. 


CONFIGURATION
============
Configure user permissions in Administration » People » Permissions:
  - Administer guzzle http server settings. 
  
Configure the environment and server settings in the Admin UI
  - /admin/config/services/http-client-manager 
