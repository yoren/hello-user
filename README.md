# hello-user
A Demo repo for the Git Workshop at Codeable

## Exercise 3
We just realized the plugin is not working as expected. We need to fix it. While there is a right way to do it with pure JavaScript, as a PHP developer, I can't help but think a dynamic block can make things much easier for me.

### Step 1
Since we're going to change it from a static block to a dynamic block, it will be a kinda major change so let's do it in a new branch. Here I wanted to introduce a naming convention to group your branches. Common practices are like: `feature/` prefix for new features, `bugfix/` or `fix` for bug fixes, `enhancement/` for enhancements, `refactor/` for refactoring, `chore/` for chores, and `hotfix/` for hotfixes. So let's create a new branch called `feature/dynamic-block`.

```bash
git checkout -b feature/dynamic-block
```

Once the new branch is created, we can go back to the `plugins` folder and use `@wordpress/create-block` to generate a dynamic block for us:

```bash
cd ..
npx @wordpress/create-block hello-user --variant dynamic
cd hello-user
```

### Step 2
Let's see what have been changed in this dynamic block with `git status`
```
On branch feature/dynamic-block
Your branch is up to date with 'origin/feature/dynamic-block'.

Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git restore <file>..." to discard changes in working directory)
	modified:   .gitignore
	modified:   package-lock.json
	modified:   package.json
	modified:   src/block.json
	modified:   src/edit.js
	modified:   src/index.js
	modified:   src/save.js

Untracked files:
  (use "git add <file>..." to include in what will be committed)
	build/
	src/render.php

no changes added to commit (use "git add" and/or "git commit -a")
```
We noticed that some changes we previously made have been reverted, which we don't want, so we can just restore those files by:
```bash
git restore .gitignore src/edit.js
```
Also, with a dynamic block, we don't need `src/save.js` anymore, so we can just remove it:
```bash
rm src/save.js
```
Now we can commit the changes:
```bash
git add .
git commit -m "Create a dynamic block"
```

### Step 3
Since we have a PHP file to render the content on the frontend, we can easily use our favorite `wp_get_current_user()` function to get the current user's information.

```bash
npm run start
```
And let's update `src/render.php` to:
```php
<p <?php echo get_block_wrapper_attributes(); ?>>
	<?php echo sprintf( esc_html__( 'Hello %s!', 'hello-user' ), wp_get_current_user()->display_name ); ?>
</p>
```
And remember to commit this change too:
```bash
git add .
git commit -m "Use wp_get_current_user() to get the current user's information"
```

### Step 4
We're very happy to confirm the block is working as expected. So let's merge the `feature/dynamic-block` branch into the `exercise-3` branch:
```bash
git checkout exercise-3
git merge feature/dynamic-block
```
You should be seeing output like this:
```
Updating b23c58b..29ae984
Fast-forward
 package-lock.json | 2351 +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++----------------------
 package.json      |    6 +-
 src/block.json    |    3 +-
 src/index.js      |    6 -
 src/render.php    |    3 +
 src/save.js       |   24 -
 6 files changed, 1811 insertions(+), 582 deletions(-)
 create mode 100644 src/render.php
 delete mode 100644 src/save.js
```
However, if you change your mind, say, we actually don't want to merge it to `exercise-3`, we can revert the changes completely by:
```bash
git checkout exercise-3
git reset --hard HEAD~2
```
Note `HEAD~2` means the last 2 commits. If you want to revert the last commit only, you can use `HEAD~1` or `HEAD^`.

### Step 5
Say if we change our mind (again!) and this time we feel like to merge it to `excercise-3` but we don't like to have two commits being displayed in the history, we prefer to just display a single commit with the changes we made in `feature/dynamic-block` branch. We can use `git merge --squash` to achieve that:
```bash
git checkout exercise-3
git merge --squash feature/dynamic-block
git commit -m "Create a dynamic block"
```

### Step 6
Lastly, you may be wondering now that, what is `git rebase` then? Let's figure it out by doing a rebase!
We will start by doing a reset, and note that this time we use `HEAD~1`, because with the `squash` we just did, there will only be one new commit added in the `exercise-3` branch:
```bash
git reset --hard HEAD~1
```
And try `git rebase`:
```bash
git rebase feature/dynamic-block
```
You should be seeing output like this:
```
Successfully rebased and updated refs/heads/excercise-3.
```
And - it looks exactly like what we did with `git merge`, doesn't it? When git merge work with fast forward, it can be very confusing to tell the difference between `git merge` and `git rebase`. But when it comes to merge conflicts, `git rebase` will be a much better option. We will talk about merge conflicts in the next exercise.

## Continue the Git journey in exercise 4
Check out the `exercise-4` branch to continue the Git journey:
```shell
git checkout excercise-4
