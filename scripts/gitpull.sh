#!/bin/bash
echo "path:  $1"
sudo git -C $1 pull origin master
