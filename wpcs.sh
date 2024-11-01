#!/bin/bash
echo ""
echo $(tput setaf 3)Tidying PHP...$(tput setaf 7);
./vendor/bin/phpcbf . --standard=./phpcs.xml .;
echo ""
echo $(tput setaf 3)Checking PHP...$(tput setaf 7);
./vendor/bin/phpcs . --standard=./phpcs.xml;
echo ""
echo $(tput setaf 2)All done! $(tput setaf 7);