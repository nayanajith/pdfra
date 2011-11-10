#!/bin/bash
VERSION="1.6.0";
DOJO_SRC="http://download.dojotoolkit.org/release-$VERSION/dojo-release-$VERSION-src.tar.gz";
BASE_DIR="dojo-release-$VERSION-src";
SAVE_AS="$BASE_DIR.tar.gz";

echo "Downloading Dojo source...";
wget -c $DOJO_SRC -O "$SAVE_AS";
echo "Downloading Dojo source md5...";
wget -c "$DOJO_SRC.md5" -O "$SAVE_AS.md5";
echo "Checking integrity";
md5sum -c $SAVE_AS.md5;

if [[ $? == 1 ]] 
then
	exit 0;
fi

echo "Extracting file";
tar -xzvf $SAVE_AS

RELEASENAME="dojo-ucscis";
pushd .
cd $BASE_DIR/util/buildscripts/
./build.sh profileFile=../../../ucscis.profile.js action=clean,release version=$VERSION releaseName=$RELEASENAME

if [[ $? == 0 ]]
then
	echo "The build process competed without any error";
	echo "Installing $RELEASENAME ...";
	popd
	cd ../
	cp -fr "dojo-custom-build/$BASE_DIR/release/$RELEASENAME" .
	rm dojo-release
	ln -sf dojo-ucscis dojo-release
	
	echo 'Include following three lines in <ucscis_root>/core/dojo_requier.php '
	echo '<script src="<?php echo JS; ?>/dojo/ucscis.js" type="text/javascript">
<script src="<?php echo JS; ?>/dijit/ucscis.js" type="text/javascript">
<script src="<?php echo JS; ?>/dojox/ucscis.js" type="text/javascript">
';
else
	echo "Error building dojo!";
fi
