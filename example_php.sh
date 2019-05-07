#!/bin/bash

cd examples
for s in example_*.php; do php $s > a_$s.html; firefox a_$s.html; done;
cd ..
