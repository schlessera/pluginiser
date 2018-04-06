schlessera/pluginiser
=====================

Create a pseudo-plugin that can be edited through the WP file editor

[![Build Status](https://travis-ci.org/schlessera/pluginiser.svg?branch=master)](https://travis-ci.org/schlessera/pluginiser)

Quick links: [Using](#using) | [Installing](#installing) | [Contributing](#contributing) | [Support](#support)

## Using

This package implements the following commands:

### wp pluginiser create

Creates an empty plugin.

~~~
wp pluginiser create 
~~~

Creates the folder for a new empty plugin and adds a placeholder file
that contains basic plugin meta header information so that it is
recognized within the WordPress file editor.

**OPTIONS**

<slug>
Slug of the plugin to create.

**EXAMPLES**

$ wp pluginiser create my-plugin
Success: Created plugin folder for plugin: "my-plugin"



### wp pluginiser add-file

Adds a file to a plugin.

~~~
wp pluginiser add-file 
~~~

Adds a new empty file to a given plugin. You can include subfolders in
the file path that are relative to the plugin's root folder.

**OPTIONS**

<plugin>
Slug of the plugin to add a file to.

<filepath>
Path and file name for the file to add. The path should be relative to
the plugin root.

**EXAMPLES**

$ wp pluginiser add-file my-plugin subfolder/test-file.php
Success: Created file "subfolder/test-file.php"

## Installing

Installing this package requires WP-CLI 1.5 or greater. Update to the latest stable release with `wp cli update`.

Once you've done so, you can install this package with:

    wp package install git@github.com:schlessera/pluginiser.git

## Contributing

We appreciate you taking the initiative to contribute to this project.

Contributing isn’t limited to just code. We encourage you to contribute in the way that best fits your abilities, by writing tutorials, giving a demo at your local meetup, helping other users with their support questions, or revising our documentation.

For a more thorough introduction, [check out WP-CLI's guide to contributing](https://make.wordpress.org/cli/handbook/contributing/). This package follows those policy and guidelines.

### Reporting a bug

Think you’ve found a bug? We’d love for you to help us get it fixed.

Before you create a new issue, you should [search existing issues](https://github.com/schlessera/pluginiser/issues?q=label%3Abug%20) to see if there’s an existing resolution to it, or if it’s already been fixed in a newer version.

Once you’ve done a bit of searching and discovered there isn’t an open or fixed issue for your bug, please [create a new issue](https://github.com/schlessera/pluginiser/issues/new). Include as much detail as you can, and clear steps to reproduce if possible. For more guidance, [review our bug report documentation](https://make.wordpress.org/cli/handbook/bug-reports/).

### Creating a pull request

Want to contribute a new feature? Please first [open a new issue](https://github.com/schlessera/pluginiser/issues/new) to discuss whether the feature is a good fit for the project.

Once you've decided to commit the time to seeing your pull request through, [please follow our guidelines for creating a pull request](https://make.wordpress.org/cli/handbook/pull-requests/) to make sure it's a pleasant experience. See "[Setting up](https://make.wordpress.org/cli/handbook/pull-requests/#setting-up)" for details specific to working on this package locally.

## Support

Github issues aren't for general support questions, but there are other venues you can try: https://wp-cli.org/#support


*This README.md is generated dynamically from the project's codebase using `wp scaffold package-readme` ([doc](https://github.com/wp-cli/scaffold-package-command#wp-scaffold-package-readme)). To suggest changes, please submit a pull request against the corresponding part of the codebase.*
