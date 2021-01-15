Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/xenial64"

  config.vm.boot_timeout = 600
  config.ssh.connect_timeout = 30

  config.vm.network(:forwarded_port, guest: 80, host: 80)

  config.vm.provision :docker
  config.vm.provision :docker_compose, yml: "/vagrant/docker-compose.yml", rebuild: true, run: "always"
end