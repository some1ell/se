# Carthook - Selenium tests
[![Build Status](https://img.shields.io/travis/some1ell/se.svg?style=flat-square)](https://travis-ci.org/some1ell/se)

### 1. Install set of libraries (Steward)
Have a functional tests in the same repository as your application but in a separate folder.
Put tests in a `selenium-tests/` directory.

**In this directory**, simply install Steward with the following command:

```sh
$ composer require lmc/steward
```

Install **Slack notifications** with the following command:

```sh
$ composer require sasocarthook/slack
```

Install **Local notifications** for currenlty running tests with the following command:

```sh
$ composer require sasocarthook/jolinotif
```

**Note:** you will need to have [Composer](https://getcomposer.org/) installed to do this.

### 2. Download Selenium Server and browser drivers
The following step only applies if you want to download and run Selenium Standalone Server with the test browser locally right on your computer.
Another possibility is to [start Selenium Server and test browser inside a Docker container][wiki-docker].

#### Get Selenium Standalone Server
You need to download Selenium server so it can execute commands in the specified browser.
In the root directory of your tests (e.g. `selenium-tests/`)  simply run:

```sh
$ ./vendor/bin/steward install
```

This will check for the latest version of Selenium Standalone Server and download it for you (the jar file will
be placed into the `./vendor/bin` directory).

You may want to run this command as part of your CI server build, then simply use the `--no-interaction` option to
download Selenium without any interaction and print the absolute path to the jar file as the sole output.

#### Download browser drivers
If it is not already installed on your system, you will need to download Selenium driver for the browser(s) you want to
use for the tests. See [Selenium browser drivers](https://github.com/CartHook/selenium.checkout.carthook.com/wiki/Selenium-browser-drivers) for more information.

### 3. Tests
To provide a full functionality, tests have to extend the `Lmc\Steward\Test\AbstractTestCase` class.

You must also configure [PSR-4 autoloading](http://www.php-fig.org/psr/psr-4/) so that tests could be found by
Steward. Add the following to your `composer.json` file:

```json
    "autoload": {
        "psr-4": {
             "My\\": "tests/",
             "My\\Lib\\": "tests/lib/",
             "My\\ProductOrder\\": "tests/categories/product_order/",
             "My\\Carthook\\": "src/"
        }
    }
```
Don't forget to create the `selenium-tests/tests/` directory and to run `composer dump-autoload` afterwards.

### 4. Run your tests
#### Start Selenium server
Now you need to start Selenium server, which will listen for and execute commands sent from your tests.

```sh
$ java -jar ./vendor/bin/selenium-server-standalone-3.14.0.jar # the version may differ
```

This will start a single Selenium Server instance (listening on port 4444) in "no-grid" mode (meaning the server receives
and executes the commands itself).

**Note:** You may want to run Selenium  Server in a grid mode. This has the *hub* receiving commands while multiple *nodes* execute them. 
Consult --help and the `-role` option of Selenium server.

#### Run tests
Now that Selenium Server is listening, you can launch tests! Use the  `run` command:

```sh
./vendor/bin/steward run dev chrome
```

There is also a bunch of useful options for the `run` command. [More info](https://github.com/CartHook/selenium.checkout.carthook.com/wiki/Run-commands-options)

In a few moments you should see a Chrome window appear, and the running tests. See the output of the command to check the test result.

### 5. See the results and screenshots
The log is printed to the console where you run the `run` command. This could be a bit confusing, especially if you run multiple tests in parallel.

As a solution, for each testcase there is a separate file in JUnit XML format, placed in `logs/` directory. Screenshots and HTML snapshots are also saved into this directory (they are automatically generated on failed assertion or if a WebDriver command fails).

To see the current status of tests during (or after) test execution, open the `logs/results.xml` file in your browser:

Similar output in the command line interface can be obtained using the `./vendor/bin/steward results` command (see below). You can also add `-vvv` to see results of each individual test.

### 6. See the test execution timeline
You can see a visual representation of the test execution timeline. When used with Selenium Server in "grid" mode you can see which
Selenium node executed which testcase, identify possible bottlenecks and so on.

To generate the timeline, simply run the `generate-timeline` command after test build is finished:

```sh
./vendor/bin/steward generate-timeline
```

File `timeline.html` will then be generated into the `logs/` directory.

[wiki-docker]: https://github.com/CartHook/selenium.checkout.carthook.com/wiki/Start-Selenium-server---browser-inside-Docker
