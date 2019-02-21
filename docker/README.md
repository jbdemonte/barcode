On Mac, there is no need to change the docker user.

On Debian, you might need to modify the user and its group in theses scripts
```
-eJEKYLL_UID=`id -u` -eJEKYLL_GID=`id -g` \
```