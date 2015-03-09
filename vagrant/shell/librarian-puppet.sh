#!/bin/sh

# Install librarian if not present
if ! gem list | grep -q '^librarian-puppet\s'; then
    gem install librarian-puppet
fi

# Directory in which librarian-puppet should manage its modules directory
PUPPET_DIR=/etc/puppet/

# Create directory if not exists
if [ ! -d "$PUPPET_DIR" ]; then
  mkdir -p $PUPPET_DIR
fi

# Copy Puppetfile to librarian working directory
cp /vagrant/vagrant/puppet/Puppetfile $PUPPET_DIR
cd $PUPPET_DIR && librarian-puppet install --no-use-v1-api --verbose
