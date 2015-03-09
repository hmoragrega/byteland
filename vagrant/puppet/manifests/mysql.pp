# Generic MySQL class
class mysql (
  $database,
  $user,
  $pass,
  $charset = 'utf8',
  $sql = undef
) {
  class { '::mysql::server':
    remove_default_accounts => true
  }

  ::mysql::db { $database:
    ensure   => 'present',
    charset  => $charset,
    user     => $user,
    password => $pass,
    sql      => $sql,
  }
}