# hello-user
A Demo repo for the Git Workshop at Codeable

## Pre-requisites
- Git is required to be installed before this workshop. You can download it from https://git-scm.com/downloads and install it on your machine. If you're using a Mac like me, Git should be already installed on your machine.
- Other tools that are recommended to be installed for a smoother experience during the workshop:
    - Your favorite terminal app and text editor.
    - [nvm](https://github.com/nvm-sh/nvm): to manage Node and npm versions.
    - [@wordpress/create-block](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-create-block/): it will be installed during the workshop when we create the block plugin.
    - [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos): to manage PHP dependencies.
    - Github account: if you’d like to participate the collaboration session in the workshop, you need a GitHub account to submit Pull Request. Also, it is recommended to have a GitHub account so you can fork this repo and follow along the workshop.
- Tools will be using for demo purposes in the workshop but not required for attendees:
    - [oh-my-zsh](https://ohmyz.sh/): a framework for managing your zsh configuration.
    - [Fig](http://fig.io): a tool to make your terminal more interactive.
    - [Sourcetree](https://www.sourcetreeapp.com/): a GUI for Git.
    - [Fork](https://fork.dev/): a GUI for Git.

## Exercise 1
When you create a repo on https://github.com/new, it can create three files for you (which was how I got the base of this repo):
1. README.md
2. .gitignore
3. LICENSE

Now, let's use `@wordpress/create-block` to spin up the block plugin skeleton for us. This will be a standard plugin that you can add a block to the post content and display a welcome message to the user. That's why we call it "Hello User".

### Step 0
Fork this repo to your own GitHub account. You can do it by clicking the "Fork" button on the top right corner of this page.

Also, please select "Copy the main branch only" which is selected by default. This will be helpful when we're covering branching concepts.

### Step 1
If you've done Step 0, clone that repo to your local machine. If not, you can clone this repo (`git@github.com:yoren/hello-user.git`) to your local machine.

Clone a repo to your local machine.
```shell
git clone git@github.com:xxx/hello-user.git
```
or if you prefer https:
```shell
git clone https://github.com/xxx/hello-user.git
```

### Step 2
Once you have the repo on your local machine, you can run the following command to create the block plugin skeleton.
```shell
nvm use 16.20
npx @wordpress/create-block hello-user
```
`create-block` will install all its required files into the `hello-user`, which is the repo folder you just cloned. Because it will also generate a `.gitignore` file, so you will find it being modified in the `git status` output.

```shell
git status
```
You should see something similar to the following output:
```
On branch main
Your branch is up to date with 'origin/main'.

Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git restore <file>..." to discard changes in working directory)
	modified:   .gitignore

Untracked files:
  (use "git add <file>..." to include in what will be committed)
	.editorconfig
	.idea/
	build/
	hello-user.php
	package-lock.json
	package.json
	readme.txt
	src/

no changes added to commit (use "git add" and/or "git commit -a")
```

### Step 3
If you're interested in what changes are made to the `.gitignore` file, you can run the following command:
```shell
git diff .gitignore
```
Since `.gitignore` is the only file that has changes, you can use the following command to see the changes:
```shell
git diff
```
Now, let's add all the changes to the staging area.
```shell
git add .
```
And run `git status` again, you should see the following output:
```
On branch main
Your branch is up to date with 'origin/main'.

Changes to be committed:
  (use "git restore --staged <file>..." to unstage)
	new file:   .editorconfig
	modified:   .gitignore
	new file:   .idea/.gitignore
	new file:   .idea/hello-user.iml
	new file:   .idea/inspectionProfiles/Project_Default.xml
	new file:   .idea/modules.xml
	new file:   .idea/php.xml
	new file:   .idea/vcs.xml
	new file:   build/block.json
	new file:   build/index.asset.php
	new file:   build/index.css
	new file:   build/index.js
	new file:   build/style-index.css
	new file:   hello-user.php
	new file:   package-lock.json
	new file:   package.json
	new file:   readme.txt
	new file:   src/block.json
	new file:   src/edit.js
	new file:   src/editor.scss
	new file:   src/index.js
	new file:   src/save.js
	new file:   src/style.scss
```

### Step 4
Now we can commit the changes to the local repo.
```shell
git commit -m "Add block plugin skeleton"
```
You should see the following output:
```
[main 1234567] Add block plugin skeleton
 23 files changed, 16563 insertions(+), 104 deletions(-)
 create mode 100644 .editorconfig
 create mode 100644 .idea/.gitignore
 create mode 100644 .idea/hello-user.iml
 create mode 100644 .idea/inspectionProfiles/Project_Default.xml
 create mode 100644 .idea/modules.xml
 create mode 100644 .idea/php.xml
 create mode 100644 .idea/vcs.xml
 create mode 100644 build/block.json
 create mode 100644 build/index.asset.php
 create mode 100644 build/index.css
 create mode 100644 build/index.js
 create mode 100644 build/style-index.css
 create mode 100644 hello-user.php
 create mode 100644 package-lock.json
 create mode 100644 package.json
 create mode 100644 readme.txt
 create mode 100644 src/block.json
 create mode 100644 src/edit.js
 create mode 100644 src/editor.scss
 create mode 100644 src/index.js
 create mode 100644 src/save.js
 create mode 100644 src/style.scss
```

### Step 5
Add an `upstream` remote.
```shell
git remote add upstream git@github.com:yoren/hello-user.git
```
and run `git remote -v` to verify the remote is added correctly.
```
origin	git@github.com:1fixdotio/hello-user.git (fetch)
origin	git@github.com:1fixdotio/hello-user.git (push)
upstream	git@github.com:yoren/hello-user.git (fetch)
upstream	git@github.com:yoren/hello-user.git (push)
```

### Step 6
Later on, you can pull the latest changes from the upstream repo by running the following command:
```shell
git pull upstream main
```
Or check if there is any new changes by running the following command:
```shell
git fetch upstream
```
To see which remote and branch you're currently tracking, run the following command:
```shell
git branch -vv
```
You can simply push to `origin/main` by running the following command:
```shell
git push
```
And to push to other branches, you can run the following command:
```shell
git push origin <branch-name>
```

## Continue the Git journey in exercise 2
Check out the `exercise-2` branch to continue the Git journey:
```shell
git checkout excercise-2
```
