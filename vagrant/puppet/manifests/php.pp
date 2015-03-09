class { 'php':
  service => $service
}

class php_modules {
  php::module { 'fpm': }
  php::module { 'intl': }
  php::module { 'mysql': }
  php::module { 'json': }
  php::module { 'curl': }
  php::module { 'xdebug': }

  class { 'composer':
    command_name => 'composer',
    target_dir   => '/usr/local/bin'
  }
}

class php_config {
  require php_modules

  augeas { "php5fpm-ini" :
    incl    => "/etc/php5/fpm/php.ini",
    lens    => "Php.lns",
    changes => [
      "set Date/date.timezone Europe/Madrid"
    ]
  }

  augeas { "php5cli-ini" :
    incl    => "/etc/php5/cli/php.ini",
    lens    => "Php.lns",
    changes => [
      "set Date/date.timezone Europe/Madrid"
    ]
  }

  augeas { "xdebug":
    incl    => "/etc/php5/mods-available/xdebug.ini",
    lens    => "Php.lns",
    changes => [
      "set XDEBUG/xdebug.max_nesting_level 250",
    ]
  }
}

include php_config