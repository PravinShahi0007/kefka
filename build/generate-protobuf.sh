#!/usr/bin/env bash

rm -rf ./server/resources/proto/App
rm -rf ./server/resources/proto/GBPMetadata
protoc --proto_path=. --php_out=./server/resources/proto ./proto/*.proto
