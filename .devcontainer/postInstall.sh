#!/bin/bash

sudo apt install -y make

make install

sudo chmod 777 -R storage

sudo chmod 777 -R bootstrap/cache