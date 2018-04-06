Feature: Pluginiser "add-file" command
  Background:
    Given a WP install

    When I run `wp pluginiser create my-plugin`
    Then STDOUT should contain:
    """
    Success: Created plugin folder for plugin: "my-plugin"
    """

  Scenario: A plugin file can be added
    When I run `wp pluginiser add-file my-plugin test-file.php`
    Then STDOUT should contain:
    """
    Success: Created file: "test-file.php"
    """

  Scenario: A plugin file can be added within subfolders
    When I run `wp pluginiser add-file my-plugin subfolder/subsubfolder/test-file-1.php`
    Then STDOUT should contain:
    """
    Success: Created file: "subfolder/subsubfolder/test-file-1.php"
    """

    When I run `wp pluginiser add-file my-plugin subfolder/subsubfolder/test-file-2.php`
    Then STDOUT should contain:
    """
    Success: Created file: "subfolder/subsubfolder/test-file-2.php"
    """

  Scenario: A plugin file cannot use an absolute path
    When I try `wp pluginiser add-file my-plugin /tmp/test-file.php`
    Then STDOUT should be empty
    Then STDERR should contain:
    """
    Error: Absolute paths are not supported. Please provide a file or path relative to the plugin's root folder.
    """

  Scenario: A plugin file that already exists cannot be created
    When I run `wp pluginiser add-file my-plugin test-file.php`
    Then STDOUT should contain:
    """
    Success: Created file: "test-file.php"
    """

    When I try `wp pluginiser add-file my-plugin test-file.php`
    Then STDOUT should be empty
    And STDERR should contain:
    """
    Error: The provided file path already exists: "test-file.php"
    """

  Scenario: A plugin file with an invalid name cannot be created
    When I try `wp pluginiser add-file my-plugin "."`
    Then STDOUT should be empty
    And STDERR should contain:
    """
    Error: Error creating file: "."
    """
