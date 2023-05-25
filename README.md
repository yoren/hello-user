# hello-user
A Demo repo for the Git Workshop at Codeable

## Recap of the workshop
- If you're my Codeable fellow, you can find the recording of the workshop [here](https://learn.codeable.io/skills-chat/fundamentals-of-git-and-how-to-improve-their-software-development/).
- Try speeding up the video to 1.25x or 1.5x if you find it too slow.
- I was not able to finish the full demonstration of all 6 exercises in the workshop, which was really a shame especially I had to rush through the last two exercises, which I considered the highlights of the workshop.
- The repo was designed to be a self-paced workshop. You can follow the instructions in the README.md file of each exercise branch to complete the exercise. The resolution of the exercise is in its next exercise branch. I hope y'all can still find it useful.
- You're very welcome to submit a PR to this repo if you find any typo or error in the README.md file or if you have any suggestions to improve the workshop. Especially there are [3 issues](https://github.com/yoren/hello-user/issues) awaiting you to pick up! 

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

## How to use this repository
When you checkout an exercise branch, you will see a README.md file with instructions for the exercise. You can follow the instructions in the README.md file to complete the exercise. The resolution of the exercise is in its next exercise branch. For example, resolution of exercise 1 is in `exercise-2` branch.

If you have uncommited changes in your working directory, you will not be able to checkout another branch. You can either commit your changes or stash them before checking out another branch. You may not be familiar with `git stash` but I would probably call it one of my favorite git commands.

In your current working tree, if you have uncommited changes, you can stash them by running:
```shell
git stash
```

Then, to get your stashed changes back, you can run:
```shell
git stash pop
```

With `git stash pop`, it actually does two things: it gets your stashed changes back and removes the stash from the stash list. If you want to keep the stash in the stash list, you can run:
```shell
git stash apply
```

To see the list of stashes, you can run:
```shell
git stash list
```

To remove a stash from the stash list, you can run:
```shell
git stash drop stash@{n}
```

I think we're ready to start the workshop now. Let's go!

## Continue the Git journey in exercise 1
Check out the `exercise-1` branch to continue the Git journey:
```shell
git checkout excercise-1
```
