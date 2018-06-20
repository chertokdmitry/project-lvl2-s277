install:
	composer install
	
lint:
	composer run-script phpcs -- --standard=PSR1 src bin
