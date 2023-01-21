#!/bin/bash sh
aws configure set aws_access_key_id key --profile=default
aws configure set aws_secret_access_key mysecret --profile=default
aws configure set region us-east-1 --profile=default

echo "########### AWS Configure ###########"
aws configure list --profile=default