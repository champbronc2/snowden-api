# snowden-api
Endpoint: https://snowden-api.herokuapp.com/web/index.php?type=[must specify either users, messages, or conversations]
GET requests return all records by default, unless you specify &id=[id]
For example, https://snowden-api.herokuapp.com/web/index.php?type=conversations&id=91 will return the details of conversation 11, as well as all messages from that conversation

Creating a new user:
POST https://snowden-api.herokuapp.com/web/index.php?type=users payload
`{
  "name":"gopher600",
  "profile_pic_url":"www.com",
  "eth_address":"0x00f.."
}`

Creating a new conversation:
POST https://snowden-api.herokuapp.com/web/index.php?type=conversations payload
`{
  "name":"convo numbo1",
  "expiration_date":"2018-08-19 20:04:19",
  "start_distribution":"0.3",
  "user_id":"1",
  "recipient_id":"2",
  "amount":"200",
  "complete_distribution":"0.7"
}`

Creating a new message:
POST https://snowden-api.herokuapp.com/web/index.php?type=messages
`{
  "content":"20gs baby",
  "user_id":"1",
  "conversation_id":"1"
}`
Updating status of a message to confirmed:
POST https://snowden-api.herokuapp.com/web/index.php?type=confirmconversation
`{
  "id":"11"
}`
