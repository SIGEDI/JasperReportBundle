# —— Inspired by ———————————————————————————————————————————————————————————————
# https://www.strangebuzz.com/en/snippets/the-perfect-makefile-for-symfony
# Made by Vincent

# Setup ————————————————————————————————————————————————————————————————————————
# Executables
PHP          = php
COMPOSER     = composer
SYMFONY      = $(PHP) bin/console

# Executables: vendors
PHP_CS_FIXER  = $(PHP) ./tools/php-cs-fixer/vendor/bin/php-cs-fixer


## —— Composer 🧙‍♂️ ————————————————————————————————————————————————————————————
install: ## Install the project (composer, migrations, tooling & build front)
	$(COMPOSER) install
	$(COMPOSER) install --working-dir=tools/php-cs-fixer

lint-php: ## Lint PHP files with php-cs-fixer
	@$(PHP_CS_FIXER) fix --allow-risky=yes --dry-run --config=.php-cs-fixer.dist.php

fix-php: ## Fix PHP files with php-cs-fixer
	$(PHP_CS_FIXER) fix --allow-risky=yes --config=.php-cs-fixer.dist.php