<?php 
    $page = "faq.php"; 
?>
<div class="container">
    <?php if (isset($_SESSION["success"])){ ?>
        <div class="alert alert-success">
            <strong>Success!</strong> <?php echo $_SESSION["success"]; ?>
        </div>
    <?php } elseif (isset($_SESSION["failure"])) { ?>
        <div class="alert alert-danger">
            <strong>Failure!</strong> <?php echo $_SESSION["failure"]; ?>
        </div>
    <?php }
        unset($_SESSION["failure"]);
        unset($_SESSION["success"]);
    ?>
    <form method="POST" action="<?php echo generateUrl('/handlers/create-faq-handler.php')?>">
    <legend class="border-bottom mb-4">Create FAQ</legend>
    <div class="form-group">
        <label for="question">Question</label>
        <input type="text" class="form-control" id="question" name="question" placeholder="Why is nothing displaying?" required="true">
    </div>
    <div class="form-group">
        <label for="answer">Answer</label>
        <textarea class="form-control" id="answer" name="answer" rows="3" placeholder="Try clearing your cache and cookies and if that does not work contact Ben Peterson."></textarea>
    </div>
        <button type="submit" class="btn btn-primary">Add FAQ</button>
    </form>
    </div>
    <div class="container-fluid mt-4">
        <!-- All FAQs Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">All FAQs</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <table class="table table-bordered data_table" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th class="center">ID</th>
                      <th class="center">Question</th>
                      <th class="center">Answer</th>
                      <th class="center">Update</th>
                      <th class="center">Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $allFAQs = $dao->getFAQs();
                    foreach($allFAQs as $faq) { 
                  ?>
                    <tr>
                    <form method="POST" action="../pages/admin.php?id=faq">
                        <input type="hidden" name="question" value="<?php echo htmlspecialchars($faq['question']); ?>"/>
                        <input type="hidden" name="answer" value="<?php echo htmlspecialchars($faq['answer']); ?>"/>
                        <input type="hidden" name="faqID" value="<?php echo $faq['faq_id']; ?>"/>
                        <td><?php echo htmlspecialchars($faq['faq_id']); ?></td>
                        <td><?php echo htmlspecialchars($faq['question']); ?></td>
                        <td class="center">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-block bg-primary text-gray-100" data-toggle="modal" data-target="#<?php echo $faq['faq_id']; ?>">
                                Answer
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="<?php echo $faq['faq_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $faq['faq_id']; ?>Title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                         <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                         </button>
                                         </div>
                                        <div class="modal-body">
                                            <?php echo htmlspecialchars($faq['answer']);?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                            </td>
                        <td>
                            <button type="submit" name="button_id" value="update" class="btn btn-block bg-warning text-gray-100">
                                Update FAQ
                            </button>
                        </td>
                    </form>
                    <form method="POST" action="../handlers/delete-faq-handler.php">
                        <input type="hidden" name="faqID" value="<?php echo $faq['faq_id']; ?>"/>
                        <td>
                            <button type="submit" name="button_id" value="delete" class="btn btn-block bg-danger text-gray-100">
                                Delete FAQ
                            </button>
                        </td>
                    </form>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- End of All FAQs -->
</div>
