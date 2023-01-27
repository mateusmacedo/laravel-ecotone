#!/bin/bash sh
aws configure set aws_access_key_id key --profile=default
aws configure set aws_secret_access_key secret --profile=default
aws configure set region us-east-1 --profile=default

echo "########### AWS Configure ###########"
aws configure list --profile=default

aws --endpoint-url=http://localhost:4566 \
 sqs create-queue \
 --queue-name=users \
 --attributes DelaySeconds=60,\
MaximumMessageSize=200,\
MessageRetentionPeriod=3600,\
ReceiveMessageWaitTimeSeconds=5,\
VisibilityTimeout=5,\
RedrivePolicy="\"{\\\"deadLetterTargetArn\\\":\\\"arn:aws:sqs:us-east-1:000000000000:users-dlq\\\",\\\"maxReceiveCount\\\":\\\"2\\\"}\""