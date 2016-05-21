Vagrant.require_version ">=1.7"

Vagrant.configure(2) do |config|
  config.vm.box = "brightmarch/debian-8.4-amd64"
  config.vm.provision :shell, :path => "app/config/provision"

  config.vm.network "forwarded_port", guest: 8000, host: 8000, auto_correct: true
  config.vm.network "private_network", ip: "192.168.100.100"
  config.vm.hostname = "orderware.dev"

  config.ssh.forward_agent = true
  config.vm.synced_folder ".", "/var/apps/orderware", :nfs => true

  config.vm.provider "virtualbox" do |v|
    v.gui = false
    v.memory = 2048
  end
end
