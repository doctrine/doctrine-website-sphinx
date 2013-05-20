echo "Type the github username for which you wish to generate the token file followed by [ENTER]:"

read username

curl -u "$username" -d '{"scopes":["public_repo"],"note":"Doctrine Project website build task"}' \
    https://api.github.com/authorizations > github-token.json