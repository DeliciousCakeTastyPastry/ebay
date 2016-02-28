#!/bin/bash
function setvariables {
if [ -e "variables.txt"  ]
then
rm variables.txt
fi

echo "Creating variables file. Run '. variables.txt' to add them to env"
read -p "Insert keywords: " keywords
echo "Keywords set to: $keywords"

echo "export keywords=\"$keywords\"" >> variables.txt
}
