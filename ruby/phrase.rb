class Phrase

  def initialize(phrase)
    @phrase = phrase
  end

  def word_count
    @phrase.downcase.gsub(/[^a-z0-9'\s]/i, ' ').split(' ').inject({}) do |memo, word|
      binding.pry
      memo[word] = memo[word].to_i + 1
    end
  end

end
