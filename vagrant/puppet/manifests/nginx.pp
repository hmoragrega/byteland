
# Stop apache or nginx won't start due to port 80 being in use
exec { "refresh_cache":
  command => "apachectl stop",
  path    => [ "/usr/sbin/", "/sbin" ]
}

class { 'nginx': }