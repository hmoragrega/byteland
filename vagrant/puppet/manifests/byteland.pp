node 'byteland.dev' {

  import 'mysql.pp'
  include ::mysql

  import 'php.pp'
  import 'nginx.pp'
}