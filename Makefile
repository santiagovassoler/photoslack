osx-local:	# Set up your OSX machine for development at https://poundlandm2-local.ampdev.co/
	@echo "\033[92mRequest sudo privileges\033[0m";
	sudo true;
	@echo "\033[92mConfigure /etc/hosts\033[0m";
	if ! grep -q "127.0.0.1 photoslack.com" "/etc/hosts"; then echo "127.0.0.1 photoslack.com" | sudo tee -a /etc/hosts; fi;
	make osx-link-php
	make configure-local-server
	sudo apachectl restart
	composer install --no-interaction --prefer-source;
	@echo "\033[92mYou can now navigate to http://photoslack";

configure-local-server:
	sed \
	-e "s;%HOST_NAME%;photoslack;g" \
	-e "s;%DOCUMENT_ROOT%;$(PWD);g" \
	-e "s;%APACHE_LOG_DIR%;$(shell brew --prefix)/var/log/httpd/;g" \
	systems/apache/local-osx.conf.template > $(shell brew --prefix)/etc/httpd/vhosts/photoslack.conf

osx-link-php: # Re-link PHP for this project
	@echo "\033[92mUnlink brew managed php versions\033[0m";
	php-unlinker.sh
	@echo "\033[92mBuild and link dependencies\033[0m";
	brew bundle
	brew link --force --overwrite $(shell grep -Eo 'amp-php.{0,4}' Brewfile | head -1) | head -1