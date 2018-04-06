Feature: Pluginiser "create" command
  Background:
    Given a WP install

  Scenario: A plugin can be created
    When I run `wp pluginiser create my-plugin`
    Then STDOUT should contain:
    """
    Success: Created plugin folder for plugin: "my-plugin"
    """

  Scenario: An existing plugin cannot be created again
    When I run `wp pluginiser create my-plugin`
    Then STDOUT should contain:
    """
    Success: Created plugin folder for plugin: "my-plugin"
    """

    When I try `wp pluginiser create my-plugin`
    Then STDOUT should be empty
    And STDERR should contain:
    """
    Error: Plugin folder already exists: "my-plugin"
    """

  Scenario: A plugin with an invalid name cannot be created
    When I try `wp pluginiser create " / "`
    Then STDOUT should be empty
    And STDERR should contain:
    """
    Error: Could not create plugin folder for plugin: " / "
    """
