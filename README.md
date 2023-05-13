# hello-user
A Demo repo for the Git Workshop at Codeable

## Exercise 4
To help us to understand the difference between `rebase` and `merge`, let's merge/rebase two branches that we know there are conflicts.

### Step 1
Checkout the `main` branch and merge the `excercise-3` branch to it.

```bash
git checkout main
git merge excercise-3
```

You will see output like:
```
Auto-merging README.md
CONFLICT (content): Merge conflict in README.md
Automatic merge failed; fix conflicts and then commit the result.
```
So we're sure that there are conflicts between the two branches. Now let's abort the merge and use a lazy shortcut (assuming we're sure that we want to adopt everything in the `excercise-3` branch).

```bash
git merge --abort
git merge --strategy-option theirs excercise-3
```
We will firstly see the commit message editor pop up. We can just save and close it (press ESC key, then `:wq` and Enter).

Once the merge is done, let's use `git log` to draw the commit graph:

```bash
git log --all --graph --decorate --oneline
```
Add here's the commit tree we will see:
```
*   4214c69 (HEAD -> main) Merge branch 'excercise-3'
|\
* | 86893b8 (origin/main, origin/HEAD) Update instructions
* | 81af859 Add pre-requisites section
| | * f175996 (refs/stash) WIP on excercise-4: d014cf3 Add instructions
| |/|
| | * 42bee87 index on excercise-4: d014cf3 Add instructions
| |/
| | * 28ce4ff (origin/feature/dynamic-block, feature/dynamic-block) Use wp_get_current_user() to get the current user's information
| | * be23679 Create a dynamic block
| |/
| * d014cf3 (origin/excercise-3, excercise-4, excercise-3) Add instructions
| * b23c58b Add gitattributes
| * 475f997 Display current user name in the block
| * ac06068 Ignore build and .idea folders
| | * 187a9fc (origin/excercise-2, excercise-2) Update instructions
| | * 5a7d4fb Update readme for exercise 2
| |/
| * f424579 Add block plugin skeleton
|/
* 6312c36 Add the instruction to force node version
* 2d82d8d Add git diff to Step 3
...
```

Make a mental note of what you see and reset the branch `git reset --hard HEAD~1` to get back to the previous state.

### Step 2
Now let's do the same thing but using `rebase` instead of `merge`.

```bash
git rebase --strategy-option theirs excercise-3
```
The first thing you'll notice is there's no commit message editor to pop up. It
just told use the base is done successfully. Let's draw the commit tree again:

```bash
git log --all --graph --decorate --oneline
```
The output will be:
```
* 246e132 (HEAD -> main) Update instructions
* f8df6b3 Add pre-requisites section
| * 35c1dc8 (refs/stash) WIP on excercise-4: d014cf3 Add instructions
|/|
| * c677f38 index on excercise-4: d014cf3 Add instructions
|/
| * 28ce4ff (origin/feature/dynamic-block, feature/dynamic-block) Use wp_get_current_user() to get the current user's information
| * be23679 Create a dynamic block
|/
* d014cf3 (origin/excercise-3, excercise-4, excercise-3) Add instructions
* b23c58b Add gitattributes
* 475f997 Display current user name in the block
* ac06068 Ignore build and .idea folders
| * 86893b8 (origin/main, origin/HEAD) Update instructions
| * 81af859 Add pre-requisites section
| | * 187a9fc (origin/excercise-2, excercise-2) Update instructions
| | * 5a7d4fb Update readme for exercise 2
| |/
|/|
* | f424579 Add block plugin skeleton
|/
* 6312c36 Add the instruction to force node version
...
```
And the second obvious difference that you'll notice is that the commit tree of the `main` branch is being **rewritten**, commits from the `excercise-3` branch are now part of the `main` branch, when comparing to use the `merge` command, there's only a new commit being created.

### Step 3
Because the commit tree has been changed drastically, we cannot use `HEAD~N` to count it back to the previous state. Luckily we can specify the commit hash to reset to.

```bash
git reset --hard 86893b8
```
There is also a pretty handy command `git reflog` that can help us see ALL the action history we've done on this repo. Unlike `git log` is purely for commit history, `git reflog` covers EVERYTHING, including `reset`, `rebase`, `merge`, `checkout`, etc.

```bash
git reflog
```
The output will be:
```
86893b8 (HEAD -> main, origin/main, origin/HEAD) HEAD@{0}: checkout: moving from excercise-4 to main
d1c9619 (origin/excercise-4, excercise-4) HEAD@{1}: reset: moving to HEAD
d1c9619 (origin/excercise-4, excercise-4) HEAD@{2}: checkout: moving from excercise-3 to excercise-4
d014cf3 (origin/excercise-3, excercise-3) HEAD@{3}: rebase (abort): updating HEAD
e041faf HEAD@{4}: rebase (start): checkout e041faf
d014cf3 (origin/excercise-3, excercise-3) HEAD@{5}: rebase (finish): returning to refs/heads/excercise-3
d014cf3 (origin/excercise-3, excercise-3) HEAD@{6}: rebase (start): checkout refs/remotes/origin/excercise-3
d014cf3 (origin/excercise-3, excercise-3) HEAD@{7}: checkout: moving from excercise-4 to excercise-3
...
```
Which you can see that it shows the whole action history across all branches.

### Step 4
There is one more command for us to learn regarding changing the commit tree, which is `cherry-pick`. It's a command that allows us to pick a commit from another branch and apply it to the current branch.

```bash
git cherry-pick ac06068 --startegy-option theirs
```
The syntax is pretty straightforward, we just need to specify the commit hash that we want to pick. And we can also use that lazy shortcut if we're sure that we want to adopt everything in the commit.

If we don't force a strategy there, it's likely we will have merge conflicts from the cherry-pick and we need to manually fix them, just like merge or rebase.

## Continue the Git journey in exercise 5
Check out the `exercise-5` branch where we will start to talk about GitHub and its nice features that can help us to collaborate with other developers.
```shell
git checkout excercise-5
```
