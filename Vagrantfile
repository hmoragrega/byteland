
Vagrant.configure(2) do |config|

  config.vm.define 'byteland' do |node|

    node.vm.box = "puphpet/ubuntu1404-x64"

    node.vm.hostname = 'byteland.dev'
    node.vm.network :forwarded_port, host: 8890, guest: 80
    node.vm.network :private_network, ip: '192.168.55.2'

    # Mount the project
    node.vm.synced_folder "./", "/var/www/byteland.dev",
      create: true,
      owner: "vagrant",
      group: "www-data",
      mount_options: ["dmode=775,fmode=764"]

    # Configure librarian puppet.
    node.vm.provision :shell, :path => "vagrant/shell/librarian-puppet.sh"

    # Use puppet to provision the box
    node.vm.provision :puppet do |puppet|
      puppet.manifests_path = 'vagrant/puppet/manifests'
      puppet.manifest_file = 'byteland.pp'
      puppet.working_directory = "/etc/puppet/"
      puppet.hiera_config_path = 'vagrant/puppet/data/hiera.yaml'
    end

  end

end
