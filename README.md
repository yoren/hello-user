# hello-user
A Demo repo for the Git Workshop at Codeable

## Exercise 5
When thinking about collaboration on GitHub, the first thing comes to our mind is the Pull Request. It's a way to propose changes to the codebase of a project. Once a PR is submitted, the project maintainers can review the changes and decide whether to merge the PR or not.

In large open source project like WordPress, how do they ensure the bare minimum code quality is assured before even start reviewing a PR? Usually PHPCS and a CI tool to run PHPCS automatically on every PR is the answer.

### Step 1
Let's add PHPCS to our hello-user plugin. First, we need to install the PHPCS and the WordPress Coding Standards. Let's get lazy again and copy the `composer.json` file from WordPress's develop repository. You can find it here: https://github.com/WordPress/wordpress-develop/blob/trunk/composer.json

You can edit some properties to suit your needs, here's an example of mine:
```json
{
	"name": "yoren/hello-user",
	"license": "GPL-2.0-or-later",
	"description": "A simple plugin to greet users when they log in.",
	"homepage": "https://wordpress.org",
	"keywords": [
		"hello", "Gutenberg", "wordpress", "wp"
	],
	"support": {
		"issues": "https://github.com/yoren/hello-user/issues"
	},
	"require": {
		"php": ">=5.6"
	},
	"repositories": [
		{
			"type": "git",
			"url": "https://github.com/WordPress/WordPress-Coding-Standards"
		}
	],
	"require-dev": {
		"dealerdirect/phpcodesniffer-composer-installer": "^0.7.0",
		"squizlabs/php_codesniffer": "^3.7.2",
		"wp-coding-standards/wpcs": "dev-develop",
		"phpcompatibility/phpcompatibility-wp": "~2.1.3",
		"yoast/phpunit-polyfills": "^1.0.1"
	},
	"config": {
		"allow-plugins": {
			"dealerdirect/phpcodesniffer-composer-installer": true
		}
	},
	"scripts": {
		"format": "@php ./vendor/squizlabs/php_codesniffer/bin/phpcbf --report=summary,source",
		"lint": "@php ./vendor/squizlabs/php_codesniffer/bin/phpcs --report=summary,source",
		"lint:errors": "@lint -n"
	}
}
```

### Step 2
Now we need to install the dependencies.

I've forced in `composer.json` to use the develop version of WPCS so it can properly support PHP 8.0. Before we install the dependencies, we want to use PHP 8.0 as our PHP version. You can switch PHP version easily if you have Homebrew installed:

```bash
brew unlink php@7.4 && brew link php@8.0
```
No worries if you have only PHP 7.4 installed, I've tested and the develop branch work with both PHP 7.4 and 8.0.

Run `composer install` and wait for the magic to happen. You should see a `vendor` folder created in your project root.

Before running PHPCS, we also need to add a configuration file. Let's copy the `phpcs.xml.dist` file from WordPress's develop repository. You can find it here: https://github.com/WordPress/wordpress-develop/blob/trunk/phpcs.xml.dist

You can also copy a light weight version of the configuration file from here: [https://github.com/yoren/hello-user/blob/excercise-6/phpcs.xml.dist](https://github.com/yoren/hello-user/blob/exercise-6/phpcs.xml.dist)

And please also add a `.cache` folder where we will cache PHPCS results. You can do it by running `mkdir .cache`.

For this `.cache` folder, we would like to allow it to be committed to the repository, but we don't want to allow its content, like `phpcs.json` to be committed. We can do it by adding a `.gitignore` file in the `.cache` folder with the following content:
```gitignore
*
```

### Step 3
Let's try running PHPCS on our plugin. Run `composer run lint .` and you should see something like this:
```
> @php ./vendor/squizlabs/php_codesniffer/bin/phpcs --report=summary,source '.'
. 1 / 1 (100%)


Time: 117ms; Memory: 8MB
```
Which is very nice! It means our plugin is following the WordPress Coding Standards. It's not that surprise since it's a small plugin that has only two PHP files!

Now try breaking the coding standards in a creative way and run PHPCS again. You should see something like this:
```
> @php ./vendor/squizlabs/php_codesniffer/bin/phpcs --report=summary,source '.'
E 1 / 1 (100%)



PHP CODE SNIFFER REPORT SUMMARY
----------------------------------------------------------------------
FILE                                                  ERRORS  WARNINGS
----------------------------------------------------------------------
hello-user.php                                        1       0
----------------------------------------------------------------------
A TOTAL OF 1 ERROR AND 0 WARNINGS WERE FOUND IN 1 FILE
----------------------------------------------------------------------
PHPCBF CAN FIX 1 OF THESE SNIFF VIOLATIONS AUTOMATICALLY
----------------------------------------------------------------------

Time: 146ms; Memory: 8MB


PHP CODE SNIFFER VIOLATION SOURCE SUMMARY
-----------------------------------------------------------------------
    SOURCE                                                        COUNT
-----------------------------------------------------------------------
[x] PEAR.Functions.FunctionCallSignature.SpaceBeforeCloseBracket  1
-----------------------------------------------------------------------
A TOTAL OF 1 SNIFF VIOLATION WERE FOUND IN 1 SOURCE
-----------------------------------------------------------------------
PHPCBF CAN FIX THE 1 MARKED SOURCES AUTOMATICALLY (1 VIOLATIONS IN TOTAL)
-----------------------------------------------------------------------

Script @php ./vendor/squizlabs/php_codesniffer/bin/phpcs --report=summary,source handling the lint event returned with error code 2
```

### Step 4
As you can see, PHPCS is not happy with our code. It's complaining about a missing space before the closing bracket of a function call. It suggests that we can fix it automatically by running PHPCBF.
```
composer run format .
```
The result should be something like this:
```
> @php ./vendor/squizlabs/php_codesniffer/bin/phpcbf --report=summary,source '.'
F 1 / 1 (100%)



PHPCBF RESULT SUMMARY
----------------------------------------------------------------------
FILE                                                  FIXED  REMAINING
----------------------------------------------------------------------
hello-user.php                                        1      0
----------------------------------------------------------------------
A TOTAL OF 1 ERROR WERE FIXED IN 1 FILE
----------------------------------------------------------------------

Time: 159ms; Memory: 8MB


Script @php ./vendor/squizlabs/php_codesniffer/bin/phpcbf --report=summary,source handling the format event returned with error code 1
```

### Step 5
Although the repository comes with the PHP linting tool, we still cannot ensure that everyone runs the linting command before committing their code. We need to automate this process. This is where GitHub Actions comes in.

Create a new file called `coding-standards.yml` in `.github/workflows` folder. You can do it by running:
```bash
mkdir .github/workflows
vim .github/workflows/coding-standards.yml
```
And paste the following code:
```yaml
name: Coding Standards

on:
    push:
        branches:
            - main
    pull_request:
        branches:
            - '*'
        paths:
            # Any change to a PHP or JavaScript file should run checks.
            #      - '**.js' # We will do JS coding standards later.
            - '**.php'
            # These files configure NPM. Changes could affect the outcome.
            #      - 'package*.json' # We will do JS coding standards later.
            # These files configure Composer. Changes could affect the outcome.
            - 'composer.*'
            # Changes to workflow files should always verify all workflows are successful.
            - '.github/workflows/*.yml'
    workflow_dispatch:

# Cancels all previous workflow runs for pull requests that have not completed.
concurrency:
    # The concurrency group contains the workflow name and the branch name for pull requests
    # or the commit hash for any other events.
    group: ${{ github.workflow }}-${{ github.event_name == 'pull_request' && github.head_ref || github.sha }}
    cancel-in-progress: true

jobs:
    # Runs PHP coding standards checks.
    #
    # Violations are reported inline with annotations.
    #
    # Performs the following steps:
    # - Checks out the repository.
    # - Sets up PHP.
    # - Logs debug information.
    # - Installs Composer dependencies (use cache if possible).
    # - Make Composer packages available globally.
    # - Logs PHP_CodeSniffer debug information.
    # - Runs PHPCS on the full codebase with warnings suppressed.
    # - Runs PHPCS on the `tests` directory without warnings suppressed.
    # - Ensures version-controlled files are not modified or deleted.
    phpcs:
        name: PHP coding standards
        runs-on: ubuntu-latest
        if: ${{ github.event_name == 'pull_request' }}

        steps:
            - name: Checkout repository
              uses: actions/checkout@v3

            - name: Set up PHP
              uses: shivammathur/setup-php@v2
              with:
                  php-version: '8.0'
                  coverage: none
                  tools: composer, cs2pr

            - name: Log debug information
              run: |
                  php --version
                  composer --version

            - name: Install Composer dependencies
              uses: ramsey/composer-install@v2
              with:
                  composer-options: "--no-progress --no-ansi --no-interaction"
                  ignore-cache: "yes"

            - name: Make Composer packages available globally
              run: echo "${PWD}/vendor/bin" >> $GITHUB_PATH

            - name: Log PHPCS debug information
              run: phpcs -i

            - id: files
              uses: jitterbit/get-changed-files@v1
              continue-on-error: true

            - name: Create the PHPCS file list
              run: |
                  for changed_file in ${{ steps.files.outputs.added_modified }}; do
                    printf ${changed_file}"\n" >> $GITHUB_WORKSPACE/file-list
                  done

            - name: Run PHPCS on all changed files
              continue-on-error: true
              run: |
                  phpcs --report-full --report-checkstyle=./phpcs-report.xml -n --file-list=$GITHUB_WORKSPACE/file-list

            - name: Show PHPCS results in PR
              run: cs2pr ./phpcs-report.xml
```
The above code will run PHPCS on all PHP files that have been changed in the pull request. It will also report the results inline with annotations. This is very useful because it will show the errors and warnings in the pull request page. You can see an example of this in the [pull request](https://github.com/yoren/hello-user/pull/3), where I intentionally broke the coding standards.

## Continue the Git journey in exercise 6
Check out the `exercise-6` branch to continue the Git journey:
```shell
git checkout exercise-6
```
