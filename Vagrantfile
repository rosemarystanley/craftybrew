# -*- mode: ruby -*-
# vi: set ft=ruby :

USERNAME          = "vagrant"
DOCUMENT_ROOT     = "/var/www"      # The HTML document root that will be shared with the guest
DATABASE_PASSWORD = "~~n0t_S3cu43!" # The default root password

# This is specific to the available box package manager; i.e., apt-get for Ubuntu
PHP_VERSION       = "7.2"           # The version of PHP to install
PHP_PACKAGES      = [               # The extra PHP packages to be installed (i.e., modules)
  "php-xdebug",
  "php" + PHP_VERSION + "-mysql",
  "php" + PHP_VERSION + "-xml"
]

###############################################################################
#             Do not edit below unless you know what you're doing.            #
###############################################################################
Vagrant.require_version ">= 2.0.4"

Vagrant.configure("2") do |config|
  required_plugins = %w(
    vagrant-vbguest
  )

  plugins_to_install = required_plugins.select { |plugin| not Vagrant.has_plugin? plugin }
  if not plugins_to_install.empty?
    puts "Installing plugins: #{plugins_to_install.join(' ')}"
    if system "vagrant plugin install #{plugins_to_install.join(' ')}"
      exec "vagrant #{ARGV.join(' ')}"
    else
      abort "Installation of one or more plugins has failed. Aborting."
    end
  end

  config.vm.box = "omibee/bionic"

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network "private_network", ip: "192.168.42.10"

  config.vm.network "forwarded_port", guest: 443, host: 8443
  config.vm.network "forwarded_port", guest: 3306, host: 3306

  config.vm.provider "virtualbox" do |v|
    host = RbConfig::CONFIG['host_os']

    if host =~ /darwin/
      # sysctl returns Bytes and we need to convert to MB
      mem = `sysctl -n hw.memsize`.to_i / 1024
    elsif host =~ /linux/
      # meminfo shows KB and we need to convert to MB
      mem = `grep 'MemTotal' /proc/meminfo | sed -e 's/MemTotal://' -e 's/ kB//'`.to_i
    elsif host =~ /mswin|mingw|cygwin/
      # Windows code via https://github.com/rdsubhas/vagrant-faster
      mem = `wmic computersystem Get TotalPhysicalMemory`.split[1].to_i / 1024
    end

    # Allocate memory and cpu based on the host machine
    v.customize ["modifyvm", :id, "--memory", mem.to_i / 1024 / 4]
    v.customize ["modifyvm", :id, "--cpus", `awk "/^processor/ {++n} END {print n}" /proc/cpuinfo 2> /dev/null || sh -c 'sysctl hw.logicalcpu 2> /dev/null || echo ": 2"' | awk \'{print \$2}\'`.chomp]

    v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    v.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
    v.customize ["modifyvm", :id, "--ioapic", "on"]

    # change the network card hardware for better performance
    v.customize ["modifyvm", :id, "--nictype1", "virtio" ]
    v.customize ["modifyvm", :id, "--nictype2", "virtio" ]

    v.customize ["modifyvm", :id, "--nestedpaging", "on"]
    v.customize ["modifyvm", :id, "--largepages", "on"]
  end

  config.ssh.forward_agent = true

  config.vm.synced_folder ".", DOCUMENT_ROOT,
    id: "vagrant",
    type: "nfs",
    mount_options: ['rw', 'vers=3', 'fsc', 'rsize=1048576', 'wsize=1048576']

  config.vm.provision :shell,
   path: "bin/vagrant",
   args: "'" + USERNAME + "' '" + DOCUMENT_ROOT + "' '" + DATABASE_PASSWORD + "' '" + PHP_VERSION + "' '" + PHP_PACKAGES.join("' '") + "'"
end
