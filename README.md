# TA Ticketing Project
[http://taticketing.boisestate.edu/](http://taticketing.boisestate.edu)

# Contact
Ben Peterson

# Authors:
* Conor Cook
* Malik Herring
* Hayden Phothong
* Michael Sanchez

# Demo video
https://drive.google.com/file/d/14usS0lVFqoRgBjet-0vN0tO7L8RdwG0V/view?usp=sharing

# Technologies Used
* PHP Version: 5.4.16
* Apache Version: 2.4.6 (Red Hat Enterprise Linux)
* MySQL Version: 8.0.14 for Linux on x86_64 (MySQL Community Server - GPL)

# Frameworks/Libraries
* Bootstrap 4
* PHPUnit 4.8.36

# Project Setup
This project is a web application that is source controlled by Boise State
University on [GitHub](https://github.com/BoiseState/ta-ticketing). It is
hosted on a VM (virtual machine). The GitHub repository contains a webhook
to automatically deploy the 'master' branch to the VM.

# Important Notes

## PHPUnit 4.8.36
[List of assertions](https://phpunit.readthedocs.io/en/8.0/assertions.html#appendixes-assertions)

Run Unit-Tests: $/path/to/vendor/bin/phpunit --bootstrap /path/to/vendor/autoload.php /path/to/tests/directory/*
