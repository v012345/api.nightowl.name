#!/bin/bash
echo "path:  $1"
git -C $1 pull origin master
