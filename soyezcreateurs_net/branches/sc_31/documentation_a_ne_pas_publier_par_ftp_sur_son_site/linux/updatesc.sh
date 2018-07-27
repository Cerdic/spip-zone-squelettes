svn up
cd plugins
for inode in $(ls)
do
if
	[ -d $inode ]
then
	echo "===================================="
	echo $inode
  cd $inode
  svn up
  cd ..	
fi
done
