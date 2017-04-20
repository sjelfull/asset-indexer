#!/bin/bash
PARALLEL_JOBS=${PARALLEL_JOBS:-4}

if [ -z "$YIIC_PATH" ]; then
    echo "Path to the yiic script need to be set"
    exit 0
fi

# parallel creates a subshell, which will use the default $SHELL
# This makes sure php runs paralell with the correct shell
export SHELL=/bin/bash

index() {
    echo ""
    echo "Session id: $1 - Source id: $2 - Offset: $3"

    $YIIC_PATH assetIndexer index --sessionId=$1 --sourceId=$2 --offset=$3
    echo ""
    echo "------------"
    echo ""
}

export -f index

# Make sure logs directory exists
if [ ! -d "logs" ]; then
    mkdir logs
fi

# Index
cat $1 | parallel --progress --eta --joblog logs/parallel-es-indexing.log -j $PARALLEL_JOBS --colsep '\t' 'index {1} {2} {4}'
