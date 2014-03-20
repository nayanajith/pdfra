-- BUILDING CUSTOM DOJO BUILD --

1) download http://download.dojotoolkit.org/release-1.6.0/dojo-release-1.6.0-src.tar.gz
2) extract and copy yape.profile.js to dojo-release-1.6.0-src/util/buildscripts/profiles
3) cd to dojo-release-1.6.0-src/util/buildscripts/
4) ./build.sh profile=yape action=clean,release version=1.6.0 releaseName=dojo-yape
5) the resulting release will be availeble at ../../release
6) copy ../../release/dojo-yape to <yape_root>/js
7) cd to <yape_root>/js and run ln -sf dojo-yape dojo-release
6) in <yape_root>/core/dojo_requier.php add following javascript chunk

<script src="<?php echo JS; ?>/dijit/yape.js" type="text/javascript">
<script src="<?php echo JS; ?>/dojox/yape.js" type="text/javascript">
