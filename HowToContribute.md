ToDoAndCo - How to contribute
=============================

Improve an existing Symfony application of ToDoAndCo.
It is an application to manage daily tasks.

To contribute to this project, follow the steps below.

Step 1 - Clone or pull the project 
----------------------------------

You can do thi by clicking on the clone or download button on the top right of repository homepage

Step 2 - Work on the project
----------------------------

1. 	Install the project by referring to README.md.

2. 	Change to the repository directory on your computer :

	```
	cd toDoAndCo/
 	```

3. 	Create a dedicated **new branch** for your changes. 

	```
	git checkout -b my-new-feature upstream/features
	```

	In this example, the name of the branch is `my-new-feature` and the `upstream/features` value tells Git to create this branch based on the features branch of the upstream remote, which is the original toDoAndCo repository.

3. 	Procceed your changes.

4. 	Commit your changes:

	**Make sure to write explicit commit messages.**

5. 	Push the changes to your forked repository:
	```
	git push origin my-new-feature
	```
	
	The `origin` value is the name of the Git remote that corresponds to your forked repository and `my-new-feature` is the name of the branch you created previously.
	This will create this branch on your GitHub project.


Step 3 - Propose your changes to the project
--------------------------------------------

#### 1. 	Create a Pull Request

You can make a  **pull request**. 
Go to your repository at `https://github.com/yourGithubUsername/toDoAndCo` and you'll see that your new branch is listed at the top with a handy “Compare & pull request” button. Then click on that button and follow instructions.

On this page, ensure that the **base fork** points to the correct repository and branch. 

#### 2. 	Submit the Pull Request

Now you must submit the Pull Request to the original toDoAndCo repository.
In order to do this, press the **“Create pull request”** button and you’re done.

#### 3. 	Review by the maintainers.

Wait for the maintainer answer


#### 4. Sync your fork with the original repository after changes

The master branch of your fork won’t have the changes. In order to keep your fork synchronized with the original P8-OC-ToDoList repository, follow the steps below:

Once the changes are merged in the original P8-OC-ToDoList repository, pull its new version:
```
git pull upstream master
```

For your fork to have the changes:
```
git push origin master
```
Notice here you’re pushing to the remote named origin.



Making your Code Follow the Good Practices
------------------------------------------

#### 1. 	Coding Standards

To make every piece of code look and feel familiar, Symfony defines some coding standards that all contributions must follow.

So make sure your code respects:

* [Symfony Coding Standards](https://symfony.com/doc/3.4/contributing/code/standards.html)
* [PHP Standards Recommendations (PSR)](https://www.php-fig.org/psr/)
	* [PSR-1](https://www.php-fig.org/psr/psr-1/)
	* [PSR-2](https://www.php-fig.org/psr/psr-2/)
	* [PSR-4](https://www.php-fig.org/psr/psr-4/)
* [Symfony Best Practices](https://symfony.com/doc/3.4/best_practices/index.html)
* [Symfony Conventions](https://symfony.com/doc/3.4/contributing/code/conventions.html)

Please follow this recommendations too:

Have a readable code, use understandable variable names, extract functions if needed, avoid too complex code

#### 2. 	Quality Process

#### Code review

For this project I use this code reviewer that automates code reviews and monitors code quality over time:
* [Codacy](https://www.codacy.com/) 


### Testing

For this project, we use **PHPUnit** for unit tests and functionals tests and we have made a code coverage that you can find in the directory *web/test-coverage*.

So follow this steps:
* Run regularly PHPUnit in order to check the code
* Implement your own tests but ensure that not decrease the code coverage
* Ensure you don't change existing tests

Continuous integration has been implemented with CircleCI.

### Performance
	
To check the performance impact of this project, we use [Blackfire](https://blackfire.io/), so use it too.

Thanks for contributing !
