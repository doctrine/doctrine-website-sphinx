# Installation

For the interested party:

1. Create a file `inventory`:

        [webservers]
        doctrine ansible_ssh_host=.. ansible_ssh_port=..

2. Make sure you have a passwordless sudo account with ssh key to the doctrine webserver
3. Call:

        ansible-playbook -i inventory deploy-website.yml
