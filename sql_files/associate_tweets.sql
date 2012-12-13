select 
  tweets_new.id, 
  tweets_new.user_name,
  tweets_new.created_at as fecha_creaction,
  tweets_new.lat,
  tweets_new.long,
  tweets_new.tweet,
  tweets_new.location,
  tweet_characteristics.count_words,
  tweet_characteristics.count_tweet_mentions,
  tweet_characteristics.count_tweet_hash,
  tweet_characteristics.part_of_conversation,
  tweet_user_characteristics.number_of_tweets,
  tweet_user_characteristics.number_of_followers,
  tweet_user_characteristics.number_of_following,
  tweet_user_characteristics.number_of_lists,
  tweet_user_characteristics.`number_of_favourited`
from 
  tweets_new, 
  -- hashtags_tweets, 
  -- hashtags, 
  -- hashtags_w_count, 
  tweet_characteristics,
  tweet_user_characteristics 
where 
  -- hashtags.`id` = hashtags_tweets.`hashtag_id` and
  -- tweets_new.id = hashtags_tweets.`tweet_id` and
  -- hashtags.`id` = hashtags_w_count.`hashtag_id` and
  tweets_new.id = tweet_characteristics.tweet_id and
  tweets_new.user_name = tweet_user_characteristics.`name`